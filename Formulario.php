<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php 
        include 'funciones.inc.php';
        $errores;
        $correctos;
        $patronNombre = "/^[A-Za-z]+$/"; //REQUERIDO
        $patronApellidos = "/^([A-Z-a-z]+ )([A-Z-a-z]+)$/";
        $patronTitulo = "/^([\w ]+)+$/";
        $patronDni = "/[0-9]{8}-[A-Z]/";
        $patronTelefono = "/^[679][0-9]{8}$/"; //REQUERIDO
        $patronEmail = "/^[\w]{3,}@[\w]+.com$/";
            
        if(isset($_POST['enviar'])){
             if(        isset($_POST['nombre']) && validar_cadena($_POST['nombre']) 
                     && isset($_POST['tlf']) && validar_entero($_POST['tlf']==true)
                     && isset($_POST['titulacion']) && !empty($_POST['titulacion'])){
                 $nombre=validar_cadena($_POST['nombre']); //Hay que hacerlo después de la expresión regular
                 $telefono=filter_var(($_POST['tlf']),FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT); //,FILTER_SANITIZE_NUMBER_INT    //Filter var luego filter_VAlidate_int filter_sanitize_number
                 $titulacion=$_POST['titulacion'];
                 if(preg_match($patronNombre, $nombre) && preg_match($patronTelefono, $telefono)){
                     $correctos["nombre"]=$nombre;
                     $correctos["telefono"]=$telefono;
                     $correctos["titulacion"]=$titulacion;
                     
                     //Apellidos
                     if(isset($_POST['apellidos']) && validar_cadena($_POST['apellidos'])){
                         $apellidosVal=validar_cadena($_POST['apellidos']); //Hay que hacerlo después de la expresión regular
                         if(preg_match($patronApellidos, $apellidosVal)){
                             $apellidos=$apellidosVal;
                             $correctos['apellidos']=$apellidos;
                         }else{
                             $errores[]="Apellidos no cumple patrón";
                         }
                     }else{
                         $errores[]="Apellidos está vacío";
                     }
                     //Fin apellidos
                     
                     //DNI
                     if(isset($_POST['dni']) && !empty($_POST['dni'])){
                         if(preg_match($patronDni, $_POST['dni'])){
                             $dni=$_POST['dni'];
                             $correctos['dni']=$dni;
                         }else{
                             $errores[]="DNI no cumple patrón";
                         }
                     }else{
                         $errores[]="DNI está vacío";
                     }
                     //Fin dni
                     
                     //Genero
                     if(isset($_POST['genero']) && !empty($_POST['genero'])){
                             $genero=$_POST['genero'];
                             $correctos['genero']=$genero;
                     }else{
                         $errores[]="Género está vacío";
                     }
                     //Fin genero
                     
                     //email
                     if(isset($_POST['mail']) && validar_email($_POST['mail'])){
                         $mailVal=validar_email($_POST['mail']);
                             $mail=$mailVal;
                             $correctos['mail']=$mail;
                             
                         }else{
                         $errores[]="Mail no cumple patrón";
                     }
                     //Fin mail
                     //especialista
                     if(isset($_POST['especialista']) && !empty($_POST['especialista'])){
                         if($_POST['especialista']=="si"){
                             if(isset($_POST['titulo']) && !empty($_POST['titulo'])){
                                if(preg_match($patronTitulo, validar_cadena($_POST['titulo']))){
                                    $titulo=validar_cadena($_POST['titulo']);
                                    $correctos['titulo']=$titulo;
                                }else{
                                    $errores[]="Titulo no cumple patrón";
                                }
                             }else{
                                 $errores[]="Título está vacío";
                             }
                             
                             
                         }   
                         
                     }else{
                         $errores[]="Especialista está vacío";
                     }
                     //Fin especialista
                     
                     
                      
                        
                 }else{
                     $errores[]="O nombre o teléfono son incorrectos patrones";
                 }
             }else{
                 $errores[]="O nombre o teléfono o titulación están vacíos";
             }
            }
            
            
            ?>
        
        <h3>Curriculum</h3>
        <form name="input" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" style="border: solid 2px; margin-right: 1000px">
            <div >
                <!-- Principio del nombre-->
                Nombre: <input type="text" name="nombre" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre'] ?>"/><br>
                <!-- Fin del nombre-->

                <!--Principio del apellido -->
                Apellidos: <input type="text" name="apellidos" value="<?php if (isset($_POST['apellidos'])) echo $_POST['apellidos'] ?>"/><br>
                <!--Fin apellido -->

                <!--Principio del DNI -->
                DNI: <input type="text" name="dni" value="<?php if (isset($_POST['dni']) && preg_match($patronDni, $_POST['dni']) == 1) echo $_POST['dni'] ?>"/>

                <br>
                <!--Fin DNI -->
                
                <!--Principio del Genero -->
                Género: <input type="radio" name="genero" value="hombre"
                               <?php
                       if (isset($_POST['genero']) && ($_POST['genero']=="hombre"))
                           echo 'checked="checked"';
                       ?>/>Hombre
                        <input type="radio" name="genero" value="mujer"
                        <?php
                       if (isset($_POST['genero']) && ($_POST['genero']=="mujer"))
                           echo 'checked="checked"';
                       ?>       />Mujer<br>
                <!--Fin del Genero -->

                <!--Principio del teléfono -->
                Teléfono: <input type="number" name="tlf" value="<?php if (isset($_POST['tlf'])) echo $_POST['tlf'] ?>"/><br>
                <!--Fin del teléfono -->

                <!--Principio del mail -->
                Email: <input type="email" name="mail" value="<?php if (isset($_POST['mail'])) echo $_POST['mail'] ?>"/>
                <br>
                <!--Fin del mail -->
                
                <!--Principio del titulacion -->
                <p>Titulación: <br>
                    <input type="checkbox" name="titulacion[]" value="fpb" 
                           <?php
                       if (isset($_POST['titulacion']) && in_array("fpb", $_POST['titulacion']))
                           echo 'checked="checked"';
                       ?>/>FPB<br>
                    
                    <input type="checkbox" name="titulacion[]" value="bachillerato" 
                           <?php
                       if (isset($_POST['titulacion']) && in_array("bachillerato", $_POST['titulacion']))
                           echo 'checked="checked"';
                       ?>/>Bachillerato<br>
                    
                    <input type="checkbox" name="titulacion[]" value="smr"
                           <?php
                       if (isset($_POST['titulacion']) && in_array("smr", $_POST['titulacion']))
                           echo 'checked="checked"';
                       ?>/>SMR<br>
                    
                    <input type="checkbox" name="titulacion[]" value="asir"
                           <?php
                       if (isset($_POST['titulacion']) && in_array("asir", $_POST['titulacion']))
                           echo 'checked="checked"';
                       ?>/>ASIR<br>
                    
                    <input type="checkbox" name="titulacion[]" value="dam"
                           <?php
                       if (isset($_POST['titulacion']) && in_array("dam", $_POST['titulacion']))
                           echo 'checked="checked"';
                       ?>/>DAM<br>
                    
                    <input type="checkbox" name="titulacion[]" value="daw"
                           <?php
                       if (isset($_POST['titulacion']) && in_array("daw", $_POST['titulacion']))
                           echo 'checked="checked"';
                       ?>/>DAW<br>
                </p><br>
                <!--Fin del titulacion -->

                <!--Principio especialista-->
                <p>Título Especialista: 
                    <input type="radio" name="especialista" value="si"
                           <?php
                       if (isset($_POST['especialista']) && ($_POST['especialista']=="si"))
                           echo 'checked="checked"';
                       ?>/>Si
                    <input type="radio" name="especialista" value="no"
                           <?php
                       if (isset($_POST['especialista']) && ($_POST['especialista']=="no"))
                           echo 'checked="checked"';
                       ?>/>No<br>
                    
                    <input type="text" name="titulo" value="<?php if(isset($_POST['titulo']))echo $_POST['titulo'] ?>"/><br>
                </p>
                    <!--Fin fecha especialista -->

                <input type="submit" value="Enviar" name="enviar"/>
            </div>
        </form>
               <?php //VER RESULTADOS
               
               //ERRORES
            if(!empty($errores)){
                ?>
        <ul>
            Lo sentimos, no ha podido enviarse el currículum ya que se han encontrado los siguientes errores:
            <?php  foreach ($errores as $error){?>
                    <li><?php echo $error ?></li>
                    
            <?php } ?>
        </ul>
                        
            <?php //FIN ERRORES
             }
             //CORRECTOS
             else if(!empty ($correctos)){?>
        <ul>
            Se ha registrado tu curriculum con los datos que figuran abajo. Gracias por elegir nuestra empresa.
            <?php foreach ($correctos as $identificador => $datoCorrecto){?>
            <li> <?php echo $identificador;?>: 
                <?php if($identificador=="titulacion"){
                    foreach ($datoCorrecto as $tituloAca){
                        echo $tituloAca."<br>";
                        }   
                    }else{
                        echo $datoCorrecto."<br>";
                    }?>
            </li>
                <?php } ?>
            

                    
            <?php } //FIN CORRECTOS ?>
        </ul>
                
    </body>
</html>
