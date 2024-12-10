<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Log\Handlers\FileHandler;

class Logger extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Error Logging Threshold
     * --------------------------------------------------------------------------
     *
     * Puedes habilitar el registro de errores configurando un umbral superior a cero.
     * El umbral determina qué se registra. Cualquier valor inferior o igual al umbral será registrado.
     *
     * Las opciones de umbral son:
     *
     * - 0 = Desactiva los registros, El registro de errores APAGADO
     * - 1 = Mensajes de emergencia - El sistema no es utilizable
     * - 2 = Mensajes de alerta - Se debe tomar acción inmediatamente
     * - 3 = Mensajes críticos - Componente de aplicación no disponible, excepción inesperada
     * - 4 = Errores de ejecución - No requieren acción inmediata, pero deben ser monitoreados
     * - 5 = Advertencias - Ocurrencias excepcionales que no son errores
     * - 6 = Notificaciones - Eventos normales pero significativos
     * - 7 = Información - Eventos interesantes, como un usuario iniciando sesión, etc.
     * - 8 = Depuración - Información detallada de depuración
     * - 9 = Todos los mensajes
     *
     * Puedes pasar un array con niveles de umbral para mostrar tipos de error individuales
     *
     *     array(1, 2, 3, 8) = Mensajes de Emergencia, Alerta, Críticos y de Depuración
     *
     * Para un sitio en producción, usualmente habilitarás el nivel Crítico (3) o superior para registrar solo los errores graves.
     *
     * @var int|list<int>
     */
    public $threshold = (ENVIRONMENT === 'production') ? 4 : 9;

    /**
     * --------------------------------------------------------------------------
     * Formato de fecha para los logs
     * --------------------------------------------------------------------------
     *
     * Cada mensaje registrado tiene una fecha asociada. Puedes usar códigos de fecha PHP
     * para establecer tu propio formato de fecha.
     */
    public string $dateFormat = 'Y-m-d H:i:s';

    /**
     * --------------------------------------------------------------------------
     * Controladores de Logs
     * --------------------------------------------------------------------------
     *
     * El sistema de registro soporta múltiples acciones para cuando algo es registrado.
     * Esto se hace permitiendo varios manejadores, clases especiales diseñadas para escribir el log
     * en destinos seleccionados, ya sea un archivo en el servidor, un servicio basado en la nube, o incluso
     * enviando correos electrónicos al equipo de desarrollo.
     *
     * Cada controlador se define por el nombre de la clase utilizada para ese controlador y debe implementar
     * la interfaz `CodeIgniter\Log\Handlers\HandlerInterface`.
     *
     * Los controladores se ejecutan en el orden que se define en este array, comenzando con el primero.
     *
     * @var array<class-string, array<string, int|list<string>|string>>
     */
    public array $handlers = [
        /*
         * --------------------------------------------------------------------
         * Controlador de Archivos (File Handler)
         * --------------------------------------------------------------------
         */
        FileHandler::class => [
            // Los niveles de log que este controlador manejará.
            'handles' => [
                'critical',
                'alert',
                'emergency',
                'debug',
                'error',
                'info',
                'notice',
                'warning',
            ],

            /*
             * La extensión de archivo predeterminada para los archivos de log.
             * Una extensión de 'php' permite proteger los archivos de log a través de un script básico,
             * cuando se almacenan en un directorio accesible públicamente.
             *
             * NOTA: Dejarlo vacío utilizará la extensión predeterminada 'log'.
             */
            'fileExtension' => '',

            /*
             * Los permisos del sistema de archivos para los archivos de log recién creados.
             *
             * IMPORTANTE: Esto debe ser un número entero (sin comillas) y debes usar notación octal
             * (por ejemplo, 0700, 0644, etc.)
             */
            'filePermissions' => 0644,

            /*
             * Ruta del directorio de logs
             *
             * Por defecto, los logs se escriben en WRITEPATH . 'logs/'
             * Si lo deseas, puedes especificar un destino diferente aquí.
             */
            'path' => WRITEPATH . 'logs/',
        ],

        /*
         * El controlador ChromeLoggerHandler requiere el uso del navegador Chrome
         * y de la extensión ChromeLogger. Descomenta este bloque para usarlo.
         */
        // 'CodeIgniter\Log\Handlers\ChromeLoggerHandler' => [
        //     'handles' => ['critical', 'alert', 'emergency', 'debug', 'error', 'info', 'notice', 'warning'],
        // ],

        /*
         * El controlador ErrorlogHandler escribe los logs en la función nativa `error_log()` de PHP.
         * Descomenta este bloque para usarlo.
         */
        // 'CodeIgniter\Log\Handlers\ErrorlogHandler' => [
        //     'handles' => ['critical', 'alert', 'emergency', 'debug', 'error', 'info', 'notice', 'warning'],
        //     'messageType' => 0, // Usa ErrorlogHandler::TYPE_OS (0) o ErrorlogHandler::TYPE_SAPI (4)
        // ],
    ];
}
