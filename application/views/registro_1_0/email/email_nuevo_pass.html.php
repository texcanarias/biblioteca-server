<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Envio email</title>

        <style type="text/css">
            /* GENERICOS */
            html {
                font-size: 62.5%;
            }
            body {
                background-color: #505050;
                font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;
                margin: 0;
                padding: 0;
            }
            p,
            li,
            a,
            dt,
            dd {
                color: #555;
                font-size: 1.7rem;
            }
            dt,
            dd {
                float: left;
                font-weight: bold;
            }
            dl {
                clear: both;
                display: inline-block;
                margin: 0;
                padding-left: 1.5em;
            }
            dt {
                clear: both;
                width: 6em;
            }
            ul {
                list-style: none;
            }
            /* Estilo CONTENEDOR */
            #contenedor {
                color: #000;
                margin: 2.5% auto 0;
                overflow: hidden;
                width: 95%;
            }
            /* CABECERA */
            #cabecera {
                z-index: 1;
            }
            #cabecera #logo {
                margin: 0 0 1em 0;
                padding: 0;
            }
            /* CONTENIDO */
            #content {
                background: #fff;
                padding: 3em;
            }
        </style>
    </head>
    <body>
        <div id="contenedor">
            <div id="cabecera">
                <div id="logo">
                    <img src="cid:logo-email" alt="Logo" />
                </div>
            </div> <!-- /cabecera -->

            <div id="content">
                <p>Estimado <strong><?php echo $Nombre; ?></strong>,</p>
                <p>Ha solicitado una nueva contrase&ntilde;a en <?php echo $URL; ?>.</p> 
                <div>
                    <p>Le recordamos sus datos:</p>
                    <dl>
                        <dt>Usuario:</dt>
                        <dd><?php echo $Usuario; ?></dd>

                        <dt>Contrase&ntilde;a:</dt>
                        <dd><?php echo $Password; ?></dd>        
                    </dl>
                </div>
                <p>
                    Puede acceder a la aplicaci&oacute;n desde este enlace:<br />
                    <a href="<?php echo $URL; ?>" title="Se abrir&aacute; en una ventana nueva" target="_blank"><?php echo $URL; ?></a>
                </p>
            </div> <!-- /content -->
        </div> <!-- /contenedor -->
    </body>
</html>