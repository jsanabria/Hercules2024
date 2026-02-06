<?php

namespace PHPMaker2024\hercules;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Slim\HttpCache\CacheProvider;
use Slim\Flash\Messages;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Platforms;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Events;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Mime\MimeTypes;
use FastRoute\RouteParser\Std;
use Illuminate\Encryption\Encrypter;
use HTMLPurifier_Config;
use HTMLPurifier;

// Connections and entity managers
$definitions = [];
$dbids = array_keys(Config("Databases"));
foreach ($dbids as $dbid) {
    $definitions["connection." . $dbid] = \DI\factory(function (string $dbid) {
        return ConnectDb(Db($dbid));
    })->parameter("dbid", $dbid);
    $definitions["entitymanager." . $dbid] = \DI\factory(function (ContainerInterface $c, string $dbid) {
        $cache = IsDevelopment()
            ? DoctrineProvider::wrap(new ArrayAdapter())
            : DoctrineProvider::wrap(new FilesystemAdapter(directory: Config("DOCTRINE.CACHE_DIR")));
        $config = Setup::createAttributeMetadataConfiguration(
            Config("DOCTRINE.METADATA_DIRS"),
            IsDevelopment(),
            null,
            $cache
        );
        $conn = $c->get("connection." . $dbid);
        return new EntityManager($conn, $config);
    })->parameter("dbid", $dbid);
}

return [
    "app.cache" => \DI\create(CacheProvider::class),
    "app.flash" => fn(ContainerInterface $c) => new Messages(),
    "app.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "views/"),
    "email.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "sms.view" => fn(ContainerInterface $c) => new PhpRenderer($GLOBALS["RELATIVE_PATH"] . "lang/"),
    "app.audit" => fn(ContainerInterface $c) => (new Logger("audit"))->pushHandler(new AuditTrailHandler($GLOBALS["RELATIVE_PATH"] . "log/audit.log")), // For audit trail
    "app.logger" => fn(ContainerInterface $c) => (new Logger("log"))->pushHandler(new RotatingFileHandler($GLOBALS["RELATIVE_PATH"] . "log/log.log")),
    "sql.logger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debug.stack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "app.csrf" => fn(ContainerInterface $c) => new Guard($GLOBALS["ResponseFactory"], Config("CSRF_PREFIX")),
    "html.purifier.config" => fn(ContainerInterface $c) => HTMLPurifier_Config::createDefault(),
    "html.purifier" => fn(ContainerInterface $c) => new HTMLPurifier($c->get("html.purifier.config")),
    "debug.stack" => \DI\create(DebugStack::class),
    "debug.sql.logger" => \DI\create(DebugSqlLogger::class),
    "debug.timer" => \DI\create(Timer::class),
    "app.security" => \DI\create(AdvancedSecurity::class),
    "user.profile" => \DI\create(UserProfile::class),
    "app.session" => \DI\create(HttpSession::class),
    "mime.types" => \DI\create(MimeTypes::class),
    "app.language" => \DI\create(Language::class),
    PermissionMiddleware::class => \DI\create(PermissionMiddleware::class),
    ApiPermissionMiddleware::class => \DI\create(ApiPermissionMiddleware::class),
    JwtMiddleware::class => \DI\create(JwtMiddleware::class),
    Std::class => \DI\create(Std::class),
    Encrypter::class => fn(ContainerInterface $c) => new Encrypter(AesEncryptionKey(base64_decode(Config("AES_ENCRYPTION_KEY"))), Config("AES_ENCRYPTION_CIPHER")),

    // Tables
    "audittrail" => \DI\create(Audittrail::class),
    "autogestion_plantillas" => \DI\create(AutogestionPlantillas::class),
    "autogestion_ticket" => \DI\create(AutogestionTicket::class),
    "buscar_parcela_vc" => \DI\create(BuscarParcelaVc::class),
    "contenedor" => \DI\create(Contenedor::class),
    "costos_estructura_list" => \DI\create(CostosEstructuraList::class),
    "crear_grama" => \DI\create(CrearGrama::class),
    "disponibilidad" => \DI\create(Disponibilidad::class),
    "eliminar_servicios" => \DI\create(EliminarServicios::class),
    "eliminar_servicios_eng" => \DI\create(EliminarServiciosEng::class),
    "enviar_notificacion_cpf" => \DI\create(EnviarNotificacionCpf::class),
    "establece_cantidad_servicios" => \DI\create(EstableceCantidadServicios::class),
    "home" => \DI\create(Home::class),
    "importar_est_cost" => \DI\create(ImportarEstCost::class),
    "importar_inbox" => \DI\create(ImportarInbox::class),
    "importar_parcelas" => \DI\create(ImportarParcelas::class),
    "indicadores_01" => \DI\create(Indicadores01::class),
    "indicadores_02" => \DI\create(Indicadores02::class),
    "indicadores_03" => \DI\create(Indicadores03::class),
    "indicadores_04" => \DI\create(Indicadores04::class),
    "indicadores_05" => \DI\create(Indicadores05::class),
    "indicadores_06" => \DI\create(Indicadores06::class),
    "indicadores_10" => \DI\create(Indicadores10::class),
    "indicadores_101" => \DI\create(Indicadores101::class),
    "indicadores_102" => \DI\create(Indicadores102::class),
    "indicadores_103" => \DI\create(Indicadores103::class),
    "indicadores_104" => \DI\create(Indicadores104::class),
    "indicadores_11" => \DI\create(Indicadores11::class),
    "indicadores_12" => \DI\create(Indicadores12::class),
    "indicadores_13" => \DI\create(Indicadores13::class),
    "indicadores_14" => \DI\create(Indicadores14::class),
    "indicadores_15" => \DI\create(Indicadores15::class),
    "indicadores_151" => \DI\create(Indicadores151::class),
    "indicadores_20" => \DI\create(Indicadores20::class),
    "indicadores_201" => \DI\create(Indicadores201::class),
    "indicadores_202" => \DI\create(Indicadores202::class),
    "listado_master" => \DI\create(ListadoMaster::class),
    "listado_master_buscar" => \DI\create(ListadoMasterBuscar::class),
    "listado_master_buscar_excel" => \DI\create(ListadoMasterBuscarExcel::class),
    "listar_servicios" => \DI\create(ListarServicios::class),
    "monitoriar_servicios" => \DI\create(MonitoriarServicios::class),
    "obituario_preview" => \DI\create(ObituarioPreview::class),
    "oficio_religioso" => \DI\create(OficioReligioso::class),
    "refrigerios" => \DI\create(Refrigerios::class),
    "reporte_evaluacion" => \DI\create(ReporteEvaluacion::class),
    "reporte_evaluacion_all" => \DI\create(ReporteEvaluacionAll::class),
    "sco_adjunto" => \DI\create(ScoAdjunto::class),
    "sco_alertas" => \DI\create(ScoAlertas::class),
    "sco_articulo" => \DI\create(ScoArticulo::class),
    "sco_bloque_horario" => \DI\create(ScoBloqueHorario::class),
    "sco_chat" => \DI\create(ScoChat::class),
    "sco_chat_grupo" => \DI\create(ScoChatGrupo::class),
    "sco_cia" => \DI\create(ScoCia::class),
    "sco_cliente" => \DI\create(ScoCliente::class),
    "sco_costos" => \DI\create(ScoCostos::class),
    "sco_costos_articulos" => \DI\create(ScoCostosArticulos::class),
    "sco_costos_tarifa" => \DI\create(ScoCostosTarifa::class),
    "sco_costos_tarifa_detalle" => \DI\create(ScoCostosTarifaDetalle::class),
    "sco_costos_tipos" => \DI\create(ScoCostosTipos::class),
    "sco_cremacion_estatus" => \DI\create(ScoCremacionEstatus::class),
    "sco_email_cpf" => \DI\create(ScoEmailCpf::class),
    "sco_email_texto" => \DI\create(ScoEmailTexto::class),
    "sco_embalaje" => \DI\create(ScoEmbalaje::class),
    "sco_encuesta_calidad" => \DI\create(ScoEncuestaCalidad::class),
    "sco_entrada_salida" => \DI\create(ScoEntradaSalida::class),
    "sco_entrada_salida_detalle" => \DI\create(ScoEntradaSalidaDetalle::class),
    "sco_estatus" => \DI\create(ScoEstatus::class),
    "sco_expediente" => \DI\create(ScoExpediente::class),
    "sco_expediente_cia" => \DI\create(ScoExpedienteCia::class),
    "sco_expediente_encuesta_calidad" => \DI\create(ScoExpedienteEncuestaCalidad::class),
    "sco_expediente_estatus" => \DI\create(ScoExpedienteEstatus::class),
    "sco_expediente_old" => \DI\create(ScoExpedienteOld::class),
    "sco_expediente_seguros" => \DI\create(ScoExpedienteSeguros::class),
    "sco_expediente_seguros_adjunto" => \DI\create(ScoExpedienteSegurosAdjunto::class),
    "sco_flota" => \DI\create(ScoFlota::class),
    "sco_flota_incidencia" => \DI\create(ScoFlotaIncidencia::class),
    "sco_flota_incidencia_detalle" => \DI\create(ScoFlotaIncidenciaDetalle::class),
    "sco_funciones" => \DI\create(ScoFunciones::class),
    "sco_grama" => \DI\create(ScoGrama::class),
    "sco_grama_adjunto" => \DI\create(ScoGramaAdjunto::class),
    "sco_grama_nota" => \DI\create(ScoGramaNota::class),
    "sco_grama_pagos" => \DI\create(ScoGramaPagos::class),
    "sco_grupo_funciones" => \DI\create(ScoGrupoFunciones::class),
    "sco_lapidas" => \DI\create(ScoLapidas::class),
    "sco_lapidas_adjunto" => \DI\create(ScoLapidasAdjunto::class),
    "sco_lapidas_notas" => \DI\create(ScoLapidasNotas::class),
    "sco_lapidas_registro" => \DI\create(ScoLapidasRegistro::class),
    "sco_localidad" => \DI\create(ScoLocalidad::class),
    "sco_marca" => \DI\create(ScoMarca::class),
    "sco_mascota" => \DI\create(ScoMascota::class),
    "sco_mascota_estatus" => \DI\create(ScoMascotaEstatus::class),
    "sco_mensaje_cliente" => \DI\create(ScoMensajeCliente::class),
    "sco_modelo" => \DI\create(ScoModelo::class),
    "sco_mttotecnico" => \DI\create(ScoMttotecnico::class),
    "sco_mttotecnico_adjunto" => \DI\create(ScoMttotecnicoAdjunto::class),
    "sco_mttotecnico_notas" => \DI\create(ScoMttotecnicoNotas::class),
    "sco_nota" => \DI\create(ScoNota::class),
    "sco_nota_mascota" => \DI\create(ScoNotaMascota::class),
    "sco_nota_orden_compra" => \DI\create(ScoNotaOrdenCompra::class),
    "sco_notificaciones" => \DI\create(ScoNotificaciones::class),
    "sco_ofrece_servicio" => \DI\create(ScoOfreceServicio::class),
    "sco_orden" => \DI\create(ScoOrden::class),
    "sco_orden_compra" => \DI\create(ScoOrdenCompra::class),
    "sco_orden_compra_detalle" => \DI\create(ScoOrdenCompraDetalle::class),
    "sco_orden_salida" => \DI\create(ScoOrdenSalida::class),
    "sco_parametro" => \DI\create(ScoParametro::class),
    "sco_parcela" => \DI\create(ScoParcela::class),
    "sco_parcela_tarifa" => \DI\create(ScoParcelaTarifa::class),
    "sco_parcela_ventas" => \DI\create(ScoParcelaVentas::class),
    "sco_parcela_ventas_nota" => \DI\create(ScoParcelaVentasNota::class),
    "sco_proveedor" => \DI\create(ScoProveedor::class),
    "sco_reclamo" => \DI\create(ScoReclamo::class),
    "sco_reclamo_adjunto" => \DI\create(ScoReclamoAdjunto::class),
    "sco_reclamo_nota" => \DI\create(ScoReclamoNota::class),
    "sco_reembolso" => \DI\create(ScoReembolso::class),
    "sco_reserva" => \DI\create(ScoReserva::class),
    "sco_reserva_old" => \DI\create(ScoReservaOld::class),
    "sco_seguimiento" => \DI\create(ScoSeguimiento::class),
    "sco_seguro" => \DI\create(ScoSeguro::class),
    "sco_servicio" => \DI\create(ScoServicio::class),
    "sco_servicio_tipo" => \DI\create(ScoServicioTipo::class),
    "sco_sms" => \DI\create(ScoSms::class),
    "sco_sms_qwerty" => \DI\create(ScoSmsQwerty::class),
    "sco_tabla" => \DI\create(ScoTabla::class),
    "sco_tarifa" => \DI\create(ScoTarifa::class),
    "sco_tasa_usd" => \DI\create(ScoTasaUsd::class),
    "sco_tipo_flota" => \DI\create(ScoTipoFlota::class),
    "sco_user" => \DI\create(ScoUser::class),
    "sco_user_adjunto" => \DI\create(ScoUserAdjunto::class),
    "sco_user_nota" => \DI\create(ScoUserNota::class),
    "sco_users_online" => \DI\create(ScoUsersOnline::class),
    "seleccionar_servicios" => \DI\create(SeleccionarServicios::class),
    "sleeping" => \DI\create(Sleeping::class),
    "tarifario" => \DI\create(Tarifario::class),
    "tomar_servicio" => \DI\create(TomarServicio::class),
    "tomar_servicio2" => \DI\create(TomarServicio2::class),
    "tomar_servicio3" => \DI\create(TomarServicio3::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "view_capillas" => \DI\create(ViewCapillas::class),
    "view_exp_factura" => \DI\create(ViewExpFactura::class),
    "view_exp_mascota" => \DI\create(ViewExpMascota::class),
    "view_expediente" => \DI\create(ViewExpediente::class),
    "view_expediente_funeraria" => \DI\create(ViewExpedienteFuneraria::class),
    "view_expediente_servicio" => \DI\create(ViewExpedienteServicio::class),
    "view_fallecidos" => \DI\create(ViewFallecidos::class),
    "view_grama_pagos" => \DI\create(ViewGramaPagos::class),
    "view_insumos" => \DI\create(ViewInsumos::class),
    "view_oficio_religioso" => \DI\create(ViewOficioReligioso::class),
    "view_orden" => \DI\create(ViewOrden::class),
    "view_orden_compra" => \DI\create(ViewOrdenCompra::class),
    "view_orden_prov" => \DI\create(ViewOrdenProv::class),
    "view_parcela" => \DI\create(ViewParcela::class),
    "view_parcela_ventas" => \DI\create(ViewParcelaVentas::class),
    "view_prepara" => \DI\create(ViewPrepara::class),
    "view_reclamo_lapida" => \DI\create(ViewReclamoLapida::class),
    "view_seguimiento" => \DI\create(ViewSeguimiento::class),
    "view_servicio" => \DI\create(ViewServicio::class),
    "view_servicio_proveedor" => \DI\create(ViewServicioProveedor::class),
    "view_sms_parcelas" => \DI\create(ViewSmsParcelas::class),
    "view_velacion" => \DI\create(ViewVelacion::class),
    "update_activity" => \DI\create(UpdateActivity::class),

    // User table
    "usertable" => \DI\get("sco_user"),
] + $definitions;
