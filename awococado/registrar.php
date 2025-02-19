<?php
    include 'conexion.php'; 
    $id = $_POST['id'];

    if ($id == 'empacadora'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from empacadora where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $r=mysqli_query($enlace,'select * from empacadora where lower(RFC) = "'.mb_strtolower($_POST['RFC']).'"'); 
                $myrow=mysqli_fetch_array($r);
                if (@$myrow[0] == '' || $_POST['RFC'] == ""){
                    $conexion->beginTransaction();
                        $banderaB = false;
                        ////////////////////////// verificación de clabe y Num Cuenta
                        if ($_POST['cuenta'] != ""){
                            $r=mysqli_query($enlace,'select * from bancos where lower(NumCuenta) = "'.mb_strtolower($_POST['cuenta']).'"'); 
                            $myrow=mysqli_fetch_array($r);
                            if (@$myrow[0] != ''){
                                $banderaB = true;
                                echo 7;
                            }
                        }
                        if ($_POST['clabe'] != ""){
                            $r=mysqli_query($enlace,'select * from bancos where Clabe = "'.$_POST['clabe'].'"'); 
                            $myrow=mysqli_fetch_array($r);
                            if (@$myrow[0] != ''){
                                $banderaB = true;
                                echo 8;
                            }
                        }

                        if ($banderaB == false){
                            ////////////////////////// banco
                            $conexion->query('insert into bancos values (null, "'.$_POST['banco'].'", "'.strtoupper($_POST['cuenta']).'", "'.$_POST['clabe'].'", "E", null, null)');
                            $r=mysqli_query($enlace,"SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$bdA."' AND   TABLE_NAME   = 'bancos';"); 
                            $myrow=mysqli_fetch_array($r);
                            $banco = $myrow[0]-1;

                            ///////////////////////// insertar usuario y obtener Id
                            $resultado = regUsuarioEmp($_POST['correo'], $_POST['nombre']);
                            $r=mysqli_query($enlace,"SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$bdA."' AND   TABLE_NAME   = 'usuarios';"); 
                            $row=mysqli_fetch_array($r);
                            
                            ////////////////////////// empacadora
                            $conexion->query('insert into empacadora values (null, "'.($row[0] - 1).'", "'.$banco.'", "'.$_POST['regimen'].'", "'.$_POST['nombre'].'", "'.$_POST['direccion'].'", "'.$_POST['CP'].'", "'.$_POST['municipio'].'", "'.$_POST['telefono'].'", "'.$_POST['correo'].'", "'.strtoupper($_POST['RFC']).'", "'.$_POST['sader'].'", "'.$_POST['facturacion'].'", "'.$_POST['activacion'].'", "")');
                    if ($resultado == 1){
                        $conexion->commit();
                        echo 1;
                    } else{
                        echo $resultado;
                        $conexion->rollback();
                    }
                        }
                } else{
                    echo 6;
                }
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Empacadoras", "'.$_POST['usuario'].'", "Error al registrar a la empacadora '.mb_strtoupper($_POST['nombre']).'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'modificarEmpacadora'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace,'select * from empacadora where lower(RFC) = "'.mb_strtolower($_POST['RFC']).'" AND IdEmpacadora <> "'.$_POST['idEmpacadora'].'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == '' || $_POST['RFC'] == ""){
                $r=mysqli_query($enlace,"select u.* from usuarios as u inner join empacadora as e on e.IdUsuario = u.IdUsuario where u.Correo = '".$_POST['correo']."' AND e.IdEmpacadora <> '".$_POST['idEmpacadora']."' LIMIT 1"); 
                $myrow=mysqli_fetch_array($r);
                if (@$myrow[0] == ''){
                    $r=mysqli_query($enlace,'select * from empacadora where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'" AND IdEmpacadora <> "'.$_POST['idEmpacadora'].'" LIMIT 1'); 
                    $myrow=mysqli_fetch_array($r);
                    if (@$myrow[0] == ''){
                        $conexion->beginTransaction();
                            $banderaB = false;
                            ////////////////////////// verificación de clabe y Num Cuenta
                            if ($_POST['cuenta'] != ""){
                                $r=mysqli_query($enlace,'select b.* from bancos as b inner join empacadora as e on e.IdBanco = b.IdBanco where lower(b.NumCuenta) = "'.mb_strtolower($_POST['cuenta']).'" AND e.IdEmpacadora <> "'.$_POST['idEmpacadora'].'"'); 
                                $myrow=mysqli_fetch_array($r);
                                if (@$myrow[0] != ''){
                                    $banderaB = true;
                                    echo 4;
                                }
                            }
                            if ($_POST['clabe'] != ""){
                                $r=mysqli_query($enlace,'select b.* from bancos as b inner join empacadora as e on e.IdBanco = b.IdBanco where b.Clabe = "'.$_POST['clabe'].'" AND e.IdEmpacadora <> "'.$_POST['idEmpacadora'].'"'); 
                                $myrow=mysqli_fetch_array($r);
                                if (@$myrow[0] != ''){
                                    $banderaB = true;
                                    echo 5;
                                }
                            }

                            if ($banderaB == false){
                                ////////////////////////// banco
                                $stmt = $enlace->prepare("SELECT b.IdBanco, b.IdNombreBanco, b.NumCuenta, b.Clabe from bancos as b inner join empacadora as e on e.IdBanco = b.IdBanco WHERE e.IdEmpacadora = '".$_POST['idEmpacadora']."' LIMIT 1");
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($idBanco, $nombreB, $cuenta, $clabe);
                                $stmt->fetch();

                                $r=mysqli_query($enlace,"select * from cobros where IdBancoEmp = '".$idBanco."' LIMIT 1"); 
                                $row=mysqli_fetch_array($r);

                                if (@$row[0] == ''){
                                    $conexion->query('update bancos SET IdNombreBanco = "'.$_POST['banco'].'", NumCuenta = "'.strtoupper($_POST['cuenta']).'", Clabe = "'.$_POST['clabe'].'" where IdBanco = "'.$idBanco.'"');
                                } else{
                                    if (($nombreB != $_POST['banco']) || (strtoupper($cuenta) != strtoupper($_POST['cuenta'])) || ($clabe != $_POST['clabe'])){
                                        $conexion->query('insert into bancos values (null, "'.$_POST['banco'].'", "'.strtoupper($_POST['cuenta']).'", "'.$_POST['clabe'].'", "E", null, null)');

                                        $r=mysqli_query($enlace,"SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$bdA."' AND   TABLE_NAME   = 'bancos';"); 
                                        $myrow=mysqli_fetch_array($r);

                                        $idBanco = $myrow[0] - 1;
                                    }
                                }

                                ////////////////////////// empacadora
                                $conexion->query('update empacadora SET IdBanco = "'.$idBanco.'", IdRegimen = "'.$_POST['regimen'].'", Nombre = "'.$_POST['nombre'].'", Direccion = "'.$_POST['direccion'].'", Activa = "'.$_POST['activacion'].'", CP = "'.$_POST['CP'].'", IdMunicipio = "'.$_POST['municipio'].'", Telefono = "'.$_POST['telefono'].'", Correo = "'.$_POST['correo'].'", RFC = "'.strtoupper($_POST['RFC']).'", Sader = "'.$_POST['sader'].'", Facturacion = "'.$_POST['facturacion'].'" where IdEmpacadora = "'.$_POST['idEmpacadora'].'"');

                                $conexion->query('update usuarios as u inner join empacadora as e on e.IdUsuario = u.IdUsuario SET u.Nombre = "'.$_POST['nombre'].'", u.Correo = "'.$_POST['correo'].'" where e.IdEmpacadora = "'.$_POST['idEmpacadora'].'"');
                        $conexion->commit();
                        echo 1;
                            }
                    } else{
                        echo 7;
                    }
                } else{
                    echo 6;
                }
            } else{
                echo 3;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 2;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Empacadoras", "'.$_POST['usuario'].'", "Error al modificar una empacadora", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'tipoaportacion'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from tipoaportacion where lower(Concepto) = "'.mb_strtolower($_POST['concepto']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into tipoaportacion values (null,"'.$_POST['concepto'].'", "'.$_POST['iva'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Tipos de aportaciones", "'.$_POST['usuario'].'", "Error al registrar el tipo de aportación '.$_POST['concepto'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'expedidorcfi'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace,'select * from expedidorcfi where lower(Nombre) = "'.mb_strtolower($_POST['Nombre']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into expedidorcfi values (null,"'.$_POST['Nombre'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Oficiales", "'.$_POST['usuario'].'", "Error al registrar al oficial '.$_POST['Nombre'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'cuentasBancarias'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from bancos where lower(NumCuenta) = "'.mb_strtolower($_POST['cuenta']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $r=mysqli_query($enlace,'select * from bancos where Clabe = "'.$_POST['clabe'].'"'); 
                $myrow=mysqli_fetch_array($r);
                if (@$myrow[0] == ''){
                    $conexion->beginTransaction();
                        $conexion->query('insert into bancos values (null, "'.$_POST['banco'].'", "'.strtoupper($_POST['cuenta']).'", "'.$_POST['clabe'].'", "A", NOW(), "'.$_POST['saldo'].'")');
                    $conexion->commit();
                    echo 1;
                } else{
                    echo 3;
                }
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Cuentas bancarias", "'.$_POST['usuario'].'", "Error al registrar la cuenta bancaria con número de cuenta '.strtoupper($_POST['cuenta']).'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'nombresBancos'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from nombresbancos where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into nombresbancos values (null,"'.$_POST['nombre'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Bancos", "'.$_POST['usuario'].'", "Error al registrar el banco '.$_POST['nombre'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'estado'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from estado where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'" and IdPais = "'.$_POST['idPais'].'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into estado values (null,"'.$_POST['idPais'].'", "'.$_POST['nombre'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Estados", "'.$_POST['usuario'].'", "Error al registrar el estado '.$_POST['nombre'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'pais'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from pais where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into pais values (null, "'.$_POST['nombre'].'", '.$_POST['idGrupo'].', '.$_POST['idContinente'].')');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Países", "'.$_POST['usuario'].'", "Error al registrar el país '.$_POST['nombre'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'transporte'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from transporte where lower(Descripcion) = "'.mb_strtolower($_POST['descripcion']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into transporte values (null,"'.$_POST['descripcion'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Transportes", "'.$_POST['usuario'].'", "Error al registrar el transporte '.$_POST['descripcion'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'tercerias'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from tercerias where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into tercerias values (null,"'.$_POST['nombre'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Tercerías", "'.$_POST['usuario'].'", "Error al registrar a la tercería '.$_POST['nombre'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'tercerosEspecialistas'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from terceroespecialista where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into terceroespecialista values (null,"'.$_POST['terceria'].'","'.$_POST['nombre'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Terceros especialistas", "'.$_POST['usuario'].'", "Error al registrar al TEF '.$_POST['nombre'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'areas'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from areas where lower(Concepto) = "'.mb_strtolower($_POST['concepto']).'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into areas values (null, "'.$_POST['concepto'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Áreas", "'.$_POST['usuario'].'", "Error al registrar el área de gasto '.$_POST['concepto'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'municipio'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace,'select * from municipio where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'" and IdEstado = "'.$_POST['idEstado'].'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into municipio values (null,"'.$_POST['idEstado'].'", "'.$_POST['nombre'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Municipios", "'.$_POST['usuario'].'", "Error al registrar el municipio '.$_POST['nombre'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'certificados'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
                
            $r=mysqli_query($enlace,"select IdCertificado from certificados where lower(FolioCFI) = '".mb_strtolower($_POST['folioCFI'])."'");
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into certificados values (null,'.$_POST['idEmpacadora'].', "'.$_POST['folioCFI'].'", "'.$_POST['tipo'].'", '.$_POST['expedidorCFI'].', "'.$_POST['folioRPV'].'", "'.$_POST['TE'].'", "'.$_POST['producto'].'", "'.$_POST['variedad'].'", "'.$_POST['transporte'].'", '.$_POST['cantidad'].', "'.$_POST['unidad'].'", "'.$_POST['municipioD'].'", "'.$_POST['estado'].'", "'.$_POST['pais'].'", "'.$_POST['regulacion'].'", "Original", "'.$_POST['cajas'].'", "'.$_POST['fecha'].'", "", "'.$_POST['observaciones'].'")');

                    $r=mysqli_query($enlace,"SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$bdA."' AND   TABLE_NAME   = 'certificados';"); 
                    $myrow=mysqli_fetch_array($r);
                    $certificado = $myrow[0]-1;

                    $array [] = json_decode($_POST["municipioO"]);

                    foreach ($array as $i){
                        foreach ($i as $id => $value){
                            $conexion->query('insert into detorigen values ('.$certificado.', "'.$value[0].'")');
                        }
                    }
                $conexion->commit();
                echo "1";
            } else {
                echo "2";
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo "3";
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Certificados", "'.$_POST['usuario'].'", "Error al insertar el certificado con folio CFI '.$_POST['folioCFI'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'reemplazarC'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $conexion->beginTransaction();
                $conexion->query('update certificados SET Estatus = "Cancelado" WHERE lower(FolioCFI) = "'.mb_strtolower($_POST['folioCFIV']).'"');
                
                $r=mysqli_query($enlace,"select IdCertificado, IdEmpacadora from certificados where lower(FolioCFI) = '".mb_strtolower($_POST['folioCFIV'])."'"); 
                $myrow=mysqli_fetch_array($r);
                
                $conexion->query('insert into cancelacioncertificados values (null, "'.$myrow[0].'", "'.$_POST['justificacion'].'")');
                
                $idEmpacadora = $myrow[1];

                $conexion->query('insert into certificados values (null,'.$idEmpacadora.', "'.mb_strtoupper($_POST['folioCFIN']).'", "'.$_POST['tipo'].'", '.$_POST['expedidorCFI'].', "'.$_POST['folioRPV'].'", "'.$_POST['TE'].'", "'.$_POST['producto'].'", "'.$_POST['variedad'].'", "'.$_POST['transporte'].'", '.$_POST['cantidad'].', "'.$_POST['unidad'].'", '.$_POST['municipioD'].', '.$_POST['estado'].', '.$_POST['pais'].', '.$_POST['regulacion'].', "'.$_POST['estatus'].'", "'.$_POST['cajas'].'", "'.$_POST['fecha'].'", "'.mb_strtoupper($_POST['folioCFIV']).'", "'.$_POST['observaciones'].'")');

                $r=mysqli_query($enlace,"SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$bdA."' AND   TABLE_NAME   = 'certificados';"); 
                $myrow=mysqli_fetch_array($r);
                $certificado = $myrow[0]-1;

                $array [] = json_decode($_POST["municipioO"]);

                foreach ($array as $i){
                    foreach ($i as $id => $value){
                        $conexion->query('insert into detorigen values ('.$certificado.', "'.$value[0].'")');
                    }
                }

            $conexion->commit();
            echo "1";
        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Certificados", "'.$_POST['usuario'].'", "Error al reemplazar el certificado con folio CFI '.mb_strtoupper($_POST['folioCFIV']).'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
     if ($id == 'regulaciones'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace,'select * from regulaciones where lower(Nombre) = "'.mb_strtolower($_POST['Nombre']).'" and IdMunicipio = "'.$_POST['Municipio'].'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('insert into regulaciones values (null, "'.$_POST['Municipio'].'", "'.$_POST['Nombre'].'")');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Puertos de entrada", "'.$_POST['usuario'].'", "Error al registrar el puerto '.$_POST['Nombre'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'modEstatusCan'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $conexion->beginTransaction();
                $conexion->query('update certificados SET Estatus = "Cancelado" WHERE lower(FolioCFI) = "'.mb_strtolower($_POST['folioCFI']).'"');

                $r = mysqli_query($enlace,"select IdCertificado from certificados where lower(FolioCFI) = '".mb_strtolower($_POST['folioCFI'])."'");
                $row = mysqli_fetch_array($r);

                $conexion->query('insert into cancelacioncertificados values (null, "'.$row[0].'", "'.$_POST['justificacion'].'")');
            $conexion->commit();
            echo "1";
        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Certificados", "'.$_POST['usuario'].'", "Error al cancelar el certificado '.$_POST['folioCFI'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'crearImagen'){
        $data = $_POST['img'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        file_put_contents('Imagenes/grafica'.$_POST["nombre"].".png", $data);
    }

    if ($id == 'regFacturaAporta'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            //////////////////////////////////////// validación /////////////////////////////////////

            $b = 0;
            $r=mysqli_query($enlace,"select IdFolioAporta from facturasaporta where FolioFactura = '".$_POST['Folio']."'");
            while ($myrow=mysqli_fetch_array($r)){ 
                $b = 1;
            }

            if ($b == 0){
                $bPDF = 0;
                $BXML = 0;
                $nom = $_POST['Folio'];
                
                if (@$_FILES['archivoPDF']['name'] != ""){
                    $archivo = $_FILES['archivoPDF'];
                    $nombrefile = $_FILES['archivoPDF']['name'];
                    $rutatmp = $_FILES['archivoPDF']['tmp_name'];
                    $extension = pathinfo($nombrefile, PATHINFO_EXTENSION);
                    $rutanueva = $_SERVER['DOCUMENT_ROOT'].'/FacturasAporta/'."FacturasPDF/"."e".$nom.".".$extension;

                    if(is_uploaded_file($rutatmp)) {
                        if(copy($_FILES["archivoPDF"]["tmp_name"], $rutanueva)){
                            $bPDF = 1;
                        }
                    }
                } else{
                    $bPDF = 1;
                }
                
                if (@$_FILES['archivoXML']['name'] != ""){
                    $archivo = $_FILES['archivoXML'];
                    $nombrefile = $_FILES['archivoXML']['name'];
                    $rutatmp = $_FILES['archivoXML']['tmp_name'];
                    $extension = pathinfo($nombrefile, PATHINFO_EXTENSION);
                    $rutanueva = $_SERVER['DOCUMENT_ROOT'].'/FacturasAporta/'."FacturasXML/"."e".$nom.".".$extension;

                    if(is_uploaded_file($rutatmp)) {
                        if(copy($_FILES["archivoXML"]["tmp_name"], $rutanueva)){
                            $bXML = 1;
                        }
                    }
                } else{
                    $bXML = 1;
                }
                
                if ($bPDF == 1 && $bXML == 1){
                    require "funciones.php";
                    //////////////////////////////////////// registro ///////////////////////////////////
                    $conexion->beginTransaction();
                    $r=mysqli_query($enlace,"select Saldo from empacadora where IdEmpacadora = '".$_POST["IdEmpacadora"]."'");
                    $myrow=mysqli_fetch_array($r);
                    $saldo = $myrow[0];
                    
                    $NuevoSaldoF = $saldo + $_POST['Total'];
                    
                    $conexion->query('insert into facturasaporta values (null,"'.$_POST['IdEmpacadora'].'", "'.$_POST['Aportacion'].'", "'.$_POST['Folio'].'", "'.$_POST['Fecha'].'", "'.$_POST['Concepto'].'", "Pendiente", "'.$_POST['SubTotal'].'", "'.$_POST['Iva'].'", "'.$_POST['Total'].'", "'.$_POST['Total'].'")');
                    $conexion->query("update empacadora SET Saldo = ".$NuevoSaldoF." Where IdEmpacadora = '".$_POST['IdEmpacadora']."'");
                    $conexion->commit();
                    
                    ////////////////////////////////////// enviar correo ///////////////////////////////////
                    
                    $r=mysqli_query($enlace,"select * from empacadora where IdEmpacadora = '".$_POST["IdEmpacadora"]."'"); 
                    $myrow=mysqli_fetch_array($r);
                    $correo = $myrow[9];
                    $nombreEmp = $myrow[4];

                    $r=mysqli_query($enlace,"select a.Concepto from tipoaportacion as a inner join facturasaporta as f on f.IdTipoAportacion = a.IdTipoAportacion where FolioFactura = '".$_POST["Folio"]."'"); 
                    $myrow=mysqli_fetch_array($r);
                    $aportacion = mb_strtolower($myrow[0]);
                    
                    $to = $correo;
                    $from = $correoContador;
                    $fromName = 'AWOCOCADO';


                    /////////////////////////////// mensaje ///////////////////////////////////

                    if ($aportacion == "cuota"){
                        $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

                        $r=mysqli_query($enlace,"select * from facturasaporta where FolioFactura = '".$_POST["Folio"]."'"); 
                        $myrow=mysqli_fetch_array($r);
                        $anioF = substr($myrow[4], 0 ,4);
                        $mesF = substr($myrow[4], 5 ,2);

                        if (($mesF-1) == 0){
                            $mes = 11;
                            $anio = $anioF - 1;
                        } else{
                            $mes = $mesF - 1;
                            $anio = $anioF;
                        }

                        $r=mysqli_query($enlace,"select Cantidad from cuotas ORDER BY Fecha DESC LIMIT 1"); 
                        $myrow=mysqli_fetch_array($r);
                        $cuota = $myrow[0];

                        ///////////////// asunto ///
                        $subject = 'ENVIO DE FACTURA DE ACOPIO DEL MES DE '.strtoupper($meses[$mesF-1]).' DEL AÑO '.$anioF; 
                        ///////////////// mensaje ///
                        $htmlContent = "<p>Buen día,<br><br>
                            Adjunto factura No. ".$_POST["Folio"]." correspondiente a: Cuota por Acopio del mes de ".strtoupper($meses[$mesF-1])." de ".$anioF.".<br><br>
                            Este esquema fue un mutuo acuerdo tomado en Asambleas de nuestra asociación con representantes de empaques, cabe señalar que dicha información es obtenida de los CFI (Certificados Fitosanitarios Internacionales) emitidos por los Oficiales de SENASICA<br><br>
                            El cálculo es obtenido por los CFI correspondientes al mes de ".strtoupper($meses[$mes-1])." ".$anio." multiplicando por ".$cuota." centavos de pesos.<br><br>
                            Sin más por el momento quedo a sus ordenes.<br><br>
                            Atte Lcp. María Hernández</p>";
                    } else{
                        $r=mysqli_query($enlace,"select Concepto from facturasaporta where FolioFactura = '".$_POST["Folio"]."'"); 
                        $myrow=mysqli_fetch_array($r);
                        $concepto = $myrow[0];

                        ///////////////// asunto ///
                        $subject = 'ENVIO DE FACTURA AWOCOCADO'; 
                        ///////////////// mensaje ///
                        $htmlContent = "<p>Buen día,<br><br>
                            Adjunto factura No. ".$_POST["Folio"]." correspondiente a: ".$concepto.".<br><br>
                            Sin más por el momento quedo a sus ordenes.<br><br>
                            Atte Lcp. María Hernández</p>";
                    }
                    $htmlContent .= demoFooter();         

                    $boundary = md5(time());
                    $headers = "MIME-Version: 1.0\r\n"."From: $fromName"." <".$from.">\r\n"."Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n"; 
                    $message = "--$boundary\r\n"."Content-Type: text/html; charset=UTF-8\r\n"."Content-Transfer-Encoding: base64\r\n\r\n".chunk_split(base64_encode($htmlContent));
                    
                    ////////////////////////////////// adjuntos /////////////////////////////////

                    $filePDF = "FacturasAporta/FacturasPDF/"."e".$_POST["Folio"].".pdf";
                    $fileXML = "FacturasAporta/FacturasXML/"."e".$_POST["Folio"].".xml";
                    
                    ////////////////////////////// PDF ///
                    if(!empty($filePDF) > 0){
                        if(is_file($filePDF)){
                            $message .= "--$boundary\r\n";
                            $fp =    @fopen($filePDF,"rb");
                            $data =  @fread($fp,filesize($filePDF));
                            @fclose($fp);
                            $data = chunk_split(base64_encode($data));
                            $message .= "Content-Type: application/octet-stream; name=\"".basename($filePDF)."\"\n" . 
                            "Content-Description: ".basename($filePDF)."\n" .
                            "Content-Disposition: attachment;\n" . " filename=\"".basename($filePDF)."\"; size=".filesize($filePDF).";\n" . 
                            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                        }
                    }
                    
                    ////////////////////////////// XML ///
                    if(!empty($fileXML) > 0){
                        if(is_file($fileXML)){
                            $message .= "--$boundary\r\n";
                            $fp =    @fopen($fileXML,"rb");
                            $data =  @fread($fp,filesize($fileXML));
                            @fclose($fp);
                            $data = chunk_split(base64_encode($data));
                            $message .= "Content-Type: application/octet-stream; name=\"".basename($fileXML)."\"\n" . 
                            "Content-Description: ".basename($fileXML)."\n" .
                            "Content-Disposition: attachment;\n" . " filename=\"".basename($fileXML)."\"; size=".filesize($fileXML).";\n" . 
                            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                        }
                    }
                    $message .= "--$boundary--\r\n";
                    $returnpath = "-f" . $from;

                    ////////////////////////////////// envio /////////////////////////////////

                    if(demoEmail($to, $nombreEmp, $htmlContent) == 1){
                        $mail = @mail($to, $subject, $message, $headers, $returnpath); 
                        $respuesta = $mail?"1":"4";
                    
                        if ($respuesta == 4){
                            if (file_exists("FacturasAporta/FacturasPDF/"."e".$nom.".pdf")){
                                rename ("FacturasAporta/FacturasPDF/"."e".$nom.".pdf", "FacturasAporta/FacturasPDF/"."p".$nom.".pdf");
                            }
                        
                            if (file_exists("FacturasAporta/FacturasXML/"."e".$nom.".xml")){
                                rename ("FacturasAporta/FacturasXML/"."e".$nom.".xml", "FacturasAporta/FacturasXML/"."p".$nom.".xml");
                            }
                        }
                        echo $respuesta;
                    } else {
                        echo 4;
                    }
                } else{
                    echo "2";
                }
            } else {
                echo "3";
            }
        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Facturas empacadoras", "'.$_POST['Usuario'].'", "Error al registrar la factura con folio '.$_POST['Folio'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'modificarfactura'){
        $r=mysqli_query($enlace,"select Cantidad, IdEmpacadora, Saldo from facturasaporta where FolioFactura = '".$_POST["folio"]."'"); 
        $myrow=mysqli_fetch_array($r);
        $cantidad = $myrow[0];
        $idEmpacadora = $myrow[1];
        $saldoFactura = $myrow[2];
        
        $r=mysqli_query($enlace,"select Saldo from empacadora where IdEmpacadora = '".$idEmpacadora."'"); 
        $myrow=mysqli_fetch_array($r);
        $saldo = $myrow[0];
        
        $empacadoraSaldo = $saldo - $cantidad + $_POST ['cantidad'];
        $saldoFactura = $_POST['cantidad'] - ($cantidad - $saldoFactura);
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $conexion->beginTransaction();

            $conexion->query('update facturasaporta SET FechaEmision = "'.$_POST['fecha'].'", Cantidad = "'.$_POST['cantidad'].'", Concepto = "'.$_POST['concepto'].'", Saldo = "'.$saldoFactura.'" WHERE FolioFactura = "'.$_POST['folio'].'"');
            $conexion->query('update empacadora SET Saldo = $empacadoraSaldo Where IdEmpacadora = "'.$idEmpacadora.'"');
            $conexion->commit();
            echo "1";
        } catch (Exception $e){
            $conexion->rollback();
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'InsCobrosA'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            //////////////////////////////////////// validación PDD /////////////////////////////////////
            
            $b = 0;
            $r=mysqli_query($enlace,"select * from cobros where NumeroPDD = '".$_POST['numPDD']."'");
            $myrow=mysqli_fetch_array($r);

            if (@$myrow[0] == ''){
                ///////////////////////////////// validación de saldos
                $r=mysqli_query($enlace,"select Saldo from facturasaporta where FolioFactura = '".$_POST["folio"]."'"); 
                $myrow=mysqli_fetch_array($r);
                $saldoF = $myrow[0];
                
                if (($saldoF - $_POST["monto"]) >= 0){
                    $bPDF = 0;
                    $bXML = 0;
                    $nom = $_POST['numPDD'];
                    
                    if (@$_FILES['archivoPDF']['name'] != ""){
                        $archivo = $_FILES['archivoPDF'];
                        $nombrefile = $_FILES['archivoPDF']['name'];
                        $rutatmp = $_FILES['archivoPDF']['tmp_name'];
                        $extension = pathinfo($nombrefile, PATHINFO_EXTENSION);
                        $rutanueva = $_SERVER['DOCUMENT_ROOT']."/Cobros/CobrosPDF/e".$nom.".".$extension;

                        if(is_uploaded_file($rutatmp)) {
                            if(copy($_FILES["archivoPDF"]["tmp_name"], $rutanueva)){
                                $bPDF = 1;
                            }
                        }
                    } else{
                        $bPDF = 1;
                    }
                    
                    if (@$_FILES['archivoXML']['name'] != ""){
                        $archivo = $_FILES['archivoXML'];
                        $nombrefile = $_FILES['archivoXML']['name'];
                        $rutatmp = $_FILES['archivoXML']['tmp_name'];
                        $extension = pathinfo($nombrefile, PATHINFO_EXTENSION);
                        $rutanueva = $_SERVER['DOCUMENT_ROOT']."/Cobros/CobrosXML/e".$nom.".".$extension;

                        if(is_uploaded_file($rutatmp)) {
                            if(copy($_FILES["archivoXML"]["tmp_name"], $rutanueva)){
                                $bXML = 1;
                            }
                        }
                    } else{
                        $bXML = 1;
                    }
                    
                    if ($bPDF == 1 && $bXML == 1){
                        require "funciones.php";
                        //////////////////////////////////////// registro ///////////////////////////////////
                        $conexion->beginTransaction();
                            $r=mysqli_query($enlace,"select IdFolioAporta from facturasaporta where FolioFactura = '".$_POST["folio"]."'"); 
                            $myrow=mysqli_fetch_array($r);
                            $folio = $myrow[0];

                            $r=mysqli_query($enlace,"select Saldo from empacadora where IdEmpacadora = '".$_POST["idEmpacadora"]."'"); 
                            $myrow=mysqli_fetch_array($r);
                            $saldoE = $myrow[0];

                            $r=mysqli_query($enlace,"select IdBanco from empacadora where IdEmpacadora = '".$_POST["idEmpacadora"]."'"); 
                            $myrow=mysqli_fetch_array($r);
                            $idBanco = $myrow[0];
                            
                            $conexion->query('insert into cobros values (null,"'.$folio.'", "'.$idBanco.'", "'.$_POST['cuenta'].'", "'.$_POST['numPDD'].'", "'.$_POST['fecha'].'", "'.$_POST['monto'].'", "'.$_POST['observaciones'].'")');
                            
                            $conexion->query("update empacadora SET Saldo = '".($saldoE - $_POST["monto"])."' Where IdEmpacadora = '".$_POST['idEmpacadora']."'");
                            
                            if (($saldoF - $_POST["monto"]) == 0){
                                $conexion->query("update facturasaporta SET Estatus = 'Pagada' Where FolioFactura = '".$_POST["folio"]."'");
                            }
                            
                            $conexion->query("update facturasaporta SET Saldo = '".($saldoF - $_POST["monto"])."' Where FolioFactura = '".$_POST["folio"]."'");
                        $conexion->commit();
                        
                        ///////////////////////////////////// enviar correo ////////////////////////////////////
                        
                        $r=mysqli_query($enlace,"select * from empacadora where idEmpacadora = '".$_POST["idEmpacadora"]."'"); 
                        $myrow=mysqli_fetch_array($r);
                        $correo = $myrow[9];
                        $nombreEmp = $myrow[4];

                        $r=mysqli_query($enlace,"select a.Concepto from tipoaportacion as a inner join facturasaporta as f on f.IdTipoAportacion = a.IdTipoAportacion where FolioFactura = '".$_POST["folio"]."'"); 
                        $myrow=mysqli_fetch_array($r);
                        $aportacion = mb_strtolower($myrow[0]);
                        
                        $to = $correo;
                        $from = $correoContador;
                        $fromName = 'AWOCOCADO';

                        /////////////////////////////// mensaje ///////////////////////////////////

                        if ($aportacion == "cuota"){
                            $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

                            $r=mysqli_query($enlace,"select * from facturasaporta where FolioFactura = '".$_POST["folio"]."'"); 
                            $myrow=mysqli_fetch_array($r);
                            $anioF = substr($myrow[4], 0 ,4);
                            $mesF = substr($myrow[4], 5 ,2);

                            if (($mesF-1) == 0){
                                $mes = 11;
                                $anio = $anioF - 1;
                            } else{
                                $mes = $mesF - 1;
                                $anio = $anioF;
                            }

                            ///////////////// asunto /// 
                            $subject = 'ENVIO DE FACTURA DE PAGO DIFERIDO DEL MES DE '.strtoupper($meses[$mesF-1]).' DEL AÑO '.$anioF; 
                            ///////////////// mensaje ///
                            $htmlContent = "<p>Buen día,<br><br>
                            Adjunto factura de pago diferido No. ".$_POST["numPDD"]." correspondiente a: Cuota por Acopio del mes de ".strtoupper($meses[$mesF-1])." de ".$anioF.".<br><br>
                            Sin más por el momento quedo a sus ordenes.<br><br>
                            Atte Lcp. María Hernández</p>";
                        } else{
                            $r=mysqli_query($enlace,"select Concepto from facturasaporta where FolioFactura = '".$_POST["folio"]."'"); 
                            $myrow=mysqli_fetch_array($r);
                            $concepto = $myrow[0];

                            ///////////////// asunto ///
                            $subject = 'ENVIO DE FACTURA DE PAGO DIFERIDO AWOCOCADO'; 
                            ///////////////// mensaje ///
                            $htmlContent = "<p>Buen día,<br><br>
                            Adjunto factura de pago diferido No. ".$_POST["numPDD"]." correspondiente a: ".$concepto.".<br><br>
                            Sin más por el momento quedo a sus ordenes.<br><br>
                            Atte Lcp. María Hernández</p>";
                        }
                        $htmlContent .= demoFooter();         

                        $boundary = md5(time());
                        $headers = "MIME-Version: 1.0\r\n"."From: $fromName"." <".$from.">\r\n"."Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n"; 
                        $message = "--$boundary\r\n"."Content-Type: text/html; charset=UTF-8\r\n"."Content-Transfer-Encoding: base64\r\n\r\n".chunk_split(base64_encode($htmlContent));
                        
                        ////////////////////////////////// adjuntos /////////////////////////////////

                        $filePDF = "Cobros/CobrosPDF/"."e".$_POST["numPDD"].".pdf";
                        $fileXML = "Cobros/CobrosXML/"."e".$_POST["numPDD"].".xml";
                        
                        ////////////////////////////// PDF /////////////////////////////////////
                        if(!empty($filePDF) > 0){
                            if(is_file($filePDF)){
                                $message .= "--$boundary\r\n";
                                $fp =    @fopen($filePDF,"rb");
                                $data =  @fread($fp,filesize($filePDF));
                                @fclose($fp);
                                $data = chunk_split(base64_encode($data));
                                $message .= "Content-Type: application/octet-stream; name=\"".basename($filePDF)."\"\n" . 
                                "Content-Description: ".basename($filePDF)."\n" .
                                "Content-Disposition: attachment;\n" . " filename=\"".basename($filePDF)."\"; size=".filesize($filePDF).";\n" . 
                                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                            }
                        }
                        
                        ////////////////////////////// XML /////////////////////////////////////
                        if(!empty($fileXML) > 0){
                            if(is_file($fileXML)){
                                $message .= "--$boundary\r\n";
                                $fp =    @fopen($fileXML,"rb");
                                $data =  @fread($fp,filesize($fileXML));
                                @fclose($fp);
                                $data = chunk_split(base64_encode($data));
                                $message .= "Content-Type: application/octet-stream; name=\"".basename($fileXML)."\"\n" . 
                                "Content-Description: ".basename($fileXML)."\n" .
                                "Content-Disposition: attachment;\n" . " filename=\"".basename($fileXML)."\"; size=".filesize($fileXML).";\n" . 
                                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                            }
                        }
                        $message .= "--$boundary--\r\n";
                        $returnpath = "-f" . $from;

                        ////////////////////////////////// envio /////////////////////////////////

                        if(demoEmail($to, $nombreEmp, $htmlContent) == 1){
                            $mail = @mail($to, $subject, $message, $headers, $returnpath); 
                            $respuesta = $mail?"1":"4";
                        
                            if ($respuesta == 4){
                                if (file_exists("Cobros/CobrosPDF/"."e".$_POST["numPDD"].".pdf")){
                                    rename ("Cobros/CobrosPDF/"."e".$_POST["numPDD"].".pdf", "Cobros/CobrosPDF/"."p".$_POST["numPDD"].".pdf");
                                }
                            
                                if (file_exists("Cobros/CobrosXML/"."e".$_POST["numPDD"].".xml")){
                                    rename ("Cobros/CobrosXML/"."e".$_POST["numPDD"].".xml", "Cobros/CobrosXML/"."p".$_POST["numPDD"].".xml");
                                }
                            }
                            echo $respuesta;
                        } else {
                            echo 4;
                        }
                    } else{
                        echo "2";
                    }
                } else{
                    echo "5";
                }
            } else {
                echo "3";
            }
        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Cobros", "'.$_POST['Usuario'].'", "Error al registrar el cobro con número PDD '.$_POST["numPDD"].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
            $conexion->connection = null;
        }
    }

    if ($id == 'respaldo'){
        $db_host = $host; 
        $db_name = $bdA;
        $db_user = $usuarioA;
        $db_pass = $contraseñaA;
     
        $salida_sql = "Backups/".$_POST["nombre"].'.sql'; 
        
        $dump = 'mysqldump --add-drop-database --databases --host="'.$db_host.'" --user="'.$db_user.'" --password="'.$db_pass.'" "'.$db_name.'" > "'.$salida_sql.'"';
        exec($dump,$output,$worked);
        
        // $zip = new ZipArchive();
        // $nombreZip = "Backups/".$_POST["nombre"].'.zip'; 
        // if ($zip->open($nombreZip, ZipArchive::CREATE) === true){
        //     $zip->addFile($salida_sql);
        //     $zip->close();
        //     unlink($salida_sql);
        // }
        echo $worked;
    }

    if ($id == 'restaurar'){
        $db_host = $host; 
        $db_name = $bdA;
        $db_user = $usuarioA;
        $db_pass = $contraseñaA;
     
        $salida_sql = "Backups/".$_POST["nombre"];  
        
        // $dump = "gunzip -c '".$salida_sql.".gz' | mysql --host='".$db_host."' --user='".$usuarioA."' --password='".$contraseñaA."' '".$bdA."'";
        $dump = "mysql --host='".$db_host."' --user='".$usuarioA."' --password='".$contraseñaA."' '".$bdA."' < '".$salida_sql."'";
        exec($dump, $output, $worked); 
        echo $worked; 
    }

    if ($id == 'traspasarH'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            $conexion->beginTransaction();

            $cxHistoricos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $cxHistoricos->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            $cxHistoricos->beginTransaction();
                ////////////////////////////////// areas ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from areas"); 
                $cxHistoricos->query("truncate table areas");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into areas values ('.$myrow[0].', "'.$myrow[1].'")');
                }

                ////////////////////////////////// autoriza ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from autoriza"); 
                $cxHistoricos->query("truncate table autoriza");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into autoriza values ('.$myrow[0].', "'.$myrow[1].'", "'.$myrow[2].'")');
                }

                ////////////////////////////////// bancos ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from bancos"); 
                $cxHistoricos->query("truncate table bancos");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into bancos values ('.$myrow[0].', "'.$myrow[1].'", "'.$myrow[2].'", "'.$myrow[3].'")');
                }
                
                ////////////////////////////////// cuotas ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from cuotas"); 
                $cxHistoricos->query("truncate table cuotas");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into cuotas values ('.$myrow[0].', "'.$myrow[1].'", "'.$myrow[2].'")');
                }

                ////////////////////////////////// empacadora ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from empacadora"); 
                $cxHistoricos->query("truncate table empacadora");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into empacadora values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "'.$myrow[3].'", "'.$myrow[4].'", "'.$myrow[5].'", "'.$myrow[6].'", "'.$myrow[7].'", "'.$myrow[8].'", "'.$myrow[9].'", "'.$myrow[10].'", "'.$myrow[11].'", "'.$myrow[12].'")');
                }

                ////////////////////////////////// estado ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from estado"); 
                $cxHistoricos->query("truncate table estado");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into estado values ('.$myrow[0].', "'.$myrow[1].'", "'.$myrow[2].'")');
                }

                ////////////////////////////////// estadobd ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from estadobd"); 
                $cxHistoricos->query("truncate table estadobd");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into estadobd values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'")');
                }

                ////////////////////////////////// expedidorcfi ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from expedidorcfi"); 
                $cxHistoricos->query("truncate table expedidorcfi");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into expedidorcfi values ("'.$myrow[0].'", "'.$myrow[1].'")');
                }

                ////////////////////////////////// municipio ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from municipio"); 
                $cxHistoricos->query("truncate table municipio");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into municipio values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'")');
                }

                ////////////////////////////////// pais ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from pais"); 
                $cxHistoricos->query("truncate table pais");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into pais values ("'.$myrow[0].'", "'.$myrow[1].'")');
                }

                ////////////////////////////////// proveedores ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from proveedores"); 
                $cxHistoricos->query("truncate table proveedores");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into proveedores values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "'.$myrow[3].'", "'.$myrow[4].'", "'.$myrow[5].'", "'.$myrow[6].'", "'.$myrow[7].'")');
                }

                ////////////////////////////////// regimen ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from regimen"); 
                $cxHistoricos->query("truncate table regimen");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into regimen values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'")');
                }

                ////////////////////////////////// regulaciones ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from regulaciones"); 
                $cxHistoricos->query("truncate table regulaciones");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into regulaciones values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'")');
                }

                ////////////////////////////////// tipoaportacion ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from tipoaportacion"); 
                $cxHistoricos->query("truncate table tipoaportacion");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into tipoaportacion values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'")');
                }

                ////////////////////////////////// tipousuario ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from tipousuario"); 
                $cxHistoricos->query("truncate table tipousuario");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into tipousuario values ("'.$myrow[0].'", "'.$myrow[1].'")');
                }

                ////////////////////////////////// transporte ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from transporte"); 
                $cxHistoricos->query("truncate table transporte");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into transporte values ("'.$myrow[0].'", "'.$myrow[1].'")');
                }

                ////////////////////////////////// usuarios ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from usuarios"); 
                $cxHistoricos->query("truncate table usuarios");
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into usuarios values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "'.$myrow[3].'", "'.$myrow[4].'")');
                }


                /////////////////////////////////////////// movimientos //////////////////////////////////////////////////
                ////////////////////////////////// certificados ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from certificados where year(Fecha) = ".$_POST["año"]); 
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into certificados values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "'.$myrow[3].'", "'.$myrow[4].'", "'.$myrow[5].'", "'.$myrow[6].'", "'.$myrow[7].'", "'.$myrow[8].'", "'.$myrow[9].'", "'.$myrow[10].'", "'.$myrow[11].'", "'.$myrow[12].'", "'.$myrow[13].'", "'.$myrow[14].'", "'.$myrow[15].'", "'.$myrow[16].'", "'.$myrow[17].'", "'.$myrow[18].'", "'.$myrow[19].'", "'.$myrow[20].'", "'.$myrow[21].'", "'.$myrow[22].'")');
                    $conexion->query("delete from certificados where IdCertificado = ".$myrow[0]);
                }
                
                ////////////////////////////////// cobros  ///////////////////////////////////
                $r=mysqli_query($enlace,"select c.* from cobros as c inner join facturasaporta as f on c.IdFolioAporta = f.IdFolioAporta where year(f.FechaEmision) = ".$_POST["año"]." and f.Estatus = 'Pagada'"); 
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into cobros values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "'.$myrow[3].'", "'.$myrow[4].'", "'.$myrow[5].'")');
                    $conexion->query("delete from cobros where IdCobro = ".$myrow[0]);
                }
                
                ////////////////////////////////// facturas aporta  ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from facturasaporta where year(FechaEmision) = ".$_POST["año"]." and Estatus = 'Pagada'"); 
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into facturasaporta values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "'.$myrow[3].'", "'.$myrow[4].'", "'.$myrow[5].'", "'.$myrow[6].'", "'.$myrow[7].'", "'.$myrow[8].'", "'.$myrow[9].'", "'.$myrow[10].'")');
                    $conexion->query("delete from facturasaporta where IdFolioAporta = ".$myrow[0]);
                }

                ////////////////////////////////// pagos ///////////////////////////////////
                $r=mysqli_query($enlace,"select p.* from pagos as p inner join facturasgastos as f on p.idFolioGasto = f.idFolioGasto where year(f.FechaFactura) = ".$_POST["año"]." and f.Estatus = 'Pagada'"); 
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into pagos values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "'.$myrow[3].'", "'.$myrow[4].'", "'.$myrow[5].'", "'.$myrow[6].'", "'.$myrow[7].'")');
                    $conexion->query("delete from pagos where IdPago = ".$myrow[0]);
                }
                
                ////////////////////////////////// facturas gastos  ///////////////////////////////////
                $r=mysqli_query($enlace,"select * from facturasgastos where year(FechaFactura) = ".$_POST["año"]." and Estatus = 'Pagada'"); 
                while ($myrow=mysqli_fetch_array($r)) { 
                    $cxHistoricos->query('insert into facturasgastos values ("'.$myrow[0].'", "'.$myrow[1].'", "'.$myrow[2].'", "'.$myrow[3].'", "'.$myrow[4].'", "'.$myrow[5].'", "'.$myrow[6].'", "'.$myrow[7].'", "'.$myrow[8].'", "'.$myrow[9].'", "'.$myrow[10].'", "'.$myrow[11].'", "'.$myrow[12].'")');
                    $conexion->query("delete from facturasgastos where IdFolioGasto = ".$myrow[0]);
                }
                
            /////////////////////////////////////////// comit //////////////////////////////////////////////////
            $conexion->commit();
            $cxHistoricos->commit();
            echo "1";
        } catch (Exception $e){
            $conexion->rollback();
            $cxHistoricos->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Históricos", "", "'.$conexion->errorCode().'", "Error al traspasar la base de datos a históricos", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
            $cxHistoricos->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $cxHistoricos->connection = null;
        }
    }
    
    ////////////////////////////////////////////////FACTURAS
    if ($id == 'facturasgastos'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);

            $conexion->beginTransaction();
            $conexion->query("insert into facturasgastos values (null,'".$_POST['proveedor']."', '".$_POST['area']."', '".$_POST['autoriza']."', '".$_POST['factura']."', '".$_POST['fechaFactura']."', '".$_POST['fechaSolicitud']."', '".$_POST['cantidad']."', '".$_POST['concepto']."', '".$_POST['estatus']."', '".$_POST['mesPago']."', '".$_POST['saldo']."', '".$_POST['observacion']."')");
            //mysqli_query($enlace,$sql);
            $conexion->commit();
        
            $conexion->query("update proveedores set saldo =  saldo+ '".$_POST['saldo']."' WHERE idproveedor = '".$_POST['proveedor']."'");
            $conexion->commit();

            $conexion->query("update proveedores set total = total + '".$_POST['saldo']."' WHERE idproveedor = '".$_POST['proveedor']."'");
            $conexion->commit();
            //mysqli_query($enlace,$sql);

        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Facturas Gastos", "", "'.$conexion->errorCode().'", "Error al insertar una nueva factura de gastos", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'cancelarGasto'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace, 'select f.IdProveedor, f.Cantidad from facturasgastos as f where f.IdFolioGasto = "'.$_POST['folio'].'" AND NOT EXISTS (select p.IdFolioGasto FROM pagos as p where p.IdFolioGasto = f.IdFolioGasto)');
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] != ''){
                $conexion->beginTransaction();
                //Registrar cancelación
                $conexion->query("insert into cancelargasto values (null,'".$_POST['folio']."', '".$_POST['fecha']."', '".$_POST['motivo']."', '".$_POST['anotaciones']."')");
                $conexion->commit();
                
                //Actualizar estatus a --> Cancelada
                $conexion->query("update facturasgastos SET Estatus = 'Cancelada' WHERE IdFolioGasto = '".$_POST['folio']."'");
                $conexion->commit();
                
                //Disminuir saldo al proveedor
                $conexion->query("update proveedores SET Saldo = Saldo - '".$myrow[1]."' WHERE IdProveedor = '".$myrow[0]."'");
                $conexion->commit();
                
                //Disminuir total al proveedor
                $conexion->query("update proveedores SET Total = Total - '".$myrow[1]."' WHERE IdProveedor = '".$myrow[0]."'");
                $conexion->commit();
                
                echo 1;
            } else {
                echo 2;
            } 
        } catch (Exception $e){
            echo 3;
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Facturas Gastos", "", "'.$conexion->errorCode().'", "Error al cancelar una factura de gastos", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'autorizarGasto') {
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);
                
            $conexion->beginTransaction();
            //Actualizar estatus a --> Autorizada
            $conexion->query("update facturasgastos SET Estatus = 'Autorizada', Autorizada = NOW() WHERE IdFolioGasto = '".$_POST['folio']."'");
            $conexion->commit();
            echo 1;
        } catch (Exception $e){
            echo 2;
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Autorizar Gastos", "", "'.$conexion->errorCode().'", "Error al autorizar una factura de gastos", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'rechazarGasto') {
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);
                
            $conexion->beginTransaction();
            //Actualizar estatus a --> Rechazada
            $conexion->query("update facturasgastos SET Estatus = 'Rechazada' WHERE IdFolioGasto = '".$_POST['folio']."'");
            $conexion->commit();
            
            $motivo = ' ***NOTA: '.$_POST['motivo'];
            
            //Actualizar Observaciones
            $conexion->query("update facturasgastos SET Observaciones = concat(Observaciones, '".$motivo."') WHERE IdFolioGasto = '".$_POST['folio']."'");
            $conexion->commit();
            
            echo 1;
        } catch (Exception $e){
            echo 2;
            $conexion->rollback();
            /*$sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Autorizar Gastos", "", "'.$conexion->errorCode().'", "Error al autorizar una factura de gastos", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);*/
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'pagos'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);

            $conexion->beginTransaction();
            //Buscar IdBanco
            $r=mysqli_query($enlace,"select IdBanco from proveedores where IdProveedor = '".$_POST["prov"]."'"); 
            $myrow=mysqli_fetch_array($r);
            $idBanco = $myrow[0];
            
            //Iserción en pagos
            $conexion->query("insert into pagos values (null,'".$_POST['fact']."', '".$_POST['prov']."', '".$idBanco."' , '".$_POST['fechaPago']."', '".$_POST['monto']."', '".$_POST['modoPago']."', '".$_POST['referencia']."', '".$_POST['observaciones']."')");
            
            $conexion->commit();
            
            //Actualización en Saldo Factura
            $conexion->query("update facturasgastos set Saldo = Saldo - '".$_POST['monto']."' WHERE IdFolioGasto = '".$_POST['fact']."'");
            $conexion->commit();

            //Actualizar Saldo Proveedor
            $conexion->query("update proveedores set Total = Total - '".$_POST['monto']."' WHERE Idproveedor = '".$_POST['prov']."'");
            $conexion->commit();        

            //Actualizar estatus factura si el SaldoFactura = 0
            $conexion->query("update facturasgastos set Estatus = 'Pagada' WHERE saldo = 0");
            $conexion->commit();
            
            } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Pagos", "", "'.$conexion->errorCode().'", "Error al insertar un nuevo pago", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);          
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'cargarFacAport'){
        $nom = "p".$_POST['folio'];

        $archivo = $_FILES['archivo'];
        $nombrefile = $_FILES['archivo']['name'];
        $rutatmp = $_FILES['archivo']['tmp_name'];
        $extension = pathinfo($nombrefile, PATHINFO_EXTENSION);
        $rutanueva = $_SERVER['DOCUMENT_ROOT'].'/FacturasAporta/'."Facturas".$_POST['ext']."/".$nom.".".$extension;

        if(is_uploaded_file($rutatmp)) {
            if(copy($_FILES["archivo"]["tmp_name"], $rutanueva)){
                echo "1";
            }
        }
    }
    
    if ($id == 'eviArchConFacturas'){
        require "funciones.php";
        $r=mysqli_query($enlace,'select Correo, Nombre from empacadora where IdEmpacadora = "'.$_POST["empacadora"].'"'); 
        $myrow=mysqli_fetch_array($r);
        $correo = $myrow[0];
        $nombreEmp = $myrow[1];

        $r=mysqli_query($enlace,"select a.Concepto from tipoaportacion as a inner join facturasaporta as f on f.IdTipoAportacion = a.IdTipoAportacion where FolioFactura = '".$_POST["folio"]."'"); 
        $myrow=mysqli_fetch_array($r);
        $aportacion = mb_strtolower($myrow[0]);
        
        $to = $correo;
        $from = $correoContador;
        $fromName = 'AWOCOCADO';

        /////////////////////////////// mensaje ///////////////////////////////////

        if ($aportacion == "cuota"){
            $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

            $r=mysqli_query($enlace,"select * from facturasaporta where FolioFactura = '".$_POST["folio"]."'"); 
            $myrow=mysqli_fetch_array($r);
            $anioF = substr($myrow[4], 0 ,4);
            $mesF = substr($myrow[4], 5 ,2);

            if (($mesF-1) == 0){
                $mes = 11;
                $anio = $anioF - 1;
            } else{
                $mes = $mesF - 1;
                $anio = $anioF;
            }

            $r=mysqli_query($enlace,"select Cantidad from cuotas ORDER BY Fecha DESC LIMIT 1"); 
            $myrow=mysqli_fetch_array($r);
            $cuota = $myrow[0];

            ///////////////// asunto ///
            $subject = 'ENVIO DE FACTURA DE ACOPIO DEL MES DE '.strtoupper($meses[$mesF-1]).' DEL AÑO '.$anioF; 
            ///////////////// mensaje ///
            $htmlContent = "<p>Buen día,<br><br>
            Adjunto factura No. ".$_POST["folio"]." correspondiente a: Cuota por Acopio del mes de ".strtoupper($meses[$mesF-1])." de ".$anioF.".<br><br>
            Este esquema fue un mutuo acuerdo tomado en Asambleas de nuestra asociación con representantes de empaques, cabe señalar que dicha información es obtenida de los CFI (Certificados Fitosanitarios Internacionales) emitidos por los Oficiales de SENASICA<br><br>
            El cálculo es obtenido por los CFI correspondientes al mes de ".strtoupper($meses[$mes-1])." ".$anio." multiplicando por ".$cuota." centavos de pesos.<br><br>
            Sin más por el momento quedo a sus ordenes.<br><br>
            Atte Lcp. María Hernández</p>";
        } else{
            $r=mysqli_query($enlace,"select Concepto from facturasaporta where FolioFactura = '".$_POST["folio"]."'"); 
            $myrow=mysqli_fetch_array($r);
            $concepto = $myrow[0];

            ///////////////// asunto ///
            $subject = 'ENVIO DE FACTURA AWOCOCADO'; 
            ///////////////// mensaje ///
            $htmlContent = "<p>Buen día,<br><br>
            Adjunto factura No. ".$_POST["folio"]." correspondiente a: ".$concepto.".<br><br>
            Sin más por el momento quedo a sus ordenes.<br><br>
            Atte Lcp. María Hernández</p>";
        }
        $htmlContent .= demoFooter();

        $boundary = md5(time());
        $headers = "MIME-Version: 1.0\r\n"."From: $fromName"." <".$from.">\r\n"."Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n"; 
        $message = "--$boundary\r\n"."Content-Type: text/html; charset=UTF-8\r\n"."Content-Transfer-Encoding: base64\r\n\r\n".chunk_split(base64_encode($htmlContent));

        ////////////////////////////////// adjuntos /////////////////////////////////

        if (file_exists("FacturasAporta/FacturasPDF/"."p".$_POST["folio"].".pdf")){
            $filePDF = "FacturasAporta/FacturasPDF/"."p".$_POST["folio"].".pdf";
        } else{
            if (file_exists("FacturasAporta/FacturasPDF/"."e".$_POST["folio"].".pdf")){
                $filePDF = "FacturasAporta/FacturasPDF/"."e".$_POST["folio"].".pdf";
            }
        }
        if (file_exists("FacturasAporta/FacturasXML/"."p".$_POST["folio"].".xml")){
            $fileXML = "FacturasAporta/FacturasXML/"."p".$_POST["folio"].".xml";
        } else{
            if (file_exists("FacturasAporta/FacturasXML/"."e".$_POST["folio"].".xml")){
                $fileXML = "FacturasAporta/FacturasXML/"."e".$_POST["folio"].".xml";
            }
        } 
        
        ////////////////////////////// PDF ///
        if(!empty($filePDF) > 0){
            if(is_file($filePDF)){
                $message .= "--$boundary\r\n";
                $fp =    @fopen($filePDF,"rb");
                $data =  @fread($fp,filesize($filePDF));
                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: application/octet-stream; name=\"".basename($filePDF)."\"\n" . 
                "Content-Description: ".basename($filePDF)."\n" .
                "Content-Disposition: attachment;\n" . " filename=\"".basename($filePDF)."\"; size=".filesize($filePDF).";\n" . 
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
        
        ////////////////////////////// XML ///
        if(!empty($fileXML) > 0){
            if(is_file($fileXML)){
                $message .= "--$boundary\r\n";
                $fp =    @fopen($fileXML,"rb");
                $data =  @fread($fp,filesize($fileXML));
                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: application/octet-stream; name=\"".basename($fileXML)."\"\n" . 
                "Content-Description: ".basename($fileXML)."\n" .
                "Content-Disposition: attachment;\n" . " filename=\"".basename($fileXML)."\"; size=".filesize($fileXML).";\n" . 
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
        $message .= "--$boundary--\r\n";
        $returnpath = "-f" . $from;

        ////////////////////////////////// envio /////////////////////////////////

        if (demoEmail($to, $nombreEmp, $htmlContent) == 1){
            $mail = @mail($to, $subject, $message, $headers, $returnpath); 
            $resultado = $mail?"1":"2";
                    
            if ($resultado == 1){
                if (file_exists("FacturasAporta/FacturasPDF/"."p".$_POST["folio"].".pdf")){
                    rename ("FacturasAporta/FacturasPDF/"."p".$_POST["folio"].".pdf", "FacturasAporta/FacturasPDF/"."e".$_POST["folio"].".pdf");
                }
            
                if (file_exists("FacturasAporta/FacturasXML/"."p".$_POST["folio"].".xml")){
                    rename ("FacturasAporta/FacturasXML/"."p".$_POST["folio"].".xml", "FacturasAporta/FacturasXML/"."e".$_POST["folio"].".xml");
                }
            }
            echo $resultado;
        } else {
            echo 2;
        }
    }
    
    if ($id == 'eviArchConCobros'){
        require "funciones.php";

        $r=mysqli_query($enlace,'select Correo, Nombre from empacadora where IdEmpacadora = "'.$_POST["empacadora"].'"'); 
        $myrow=mysqli_fetch_array($r);
        $correo = $myrow[0];
        $nombreEmp = $myrow[1];
        
        $r=mysqli_query($enlace,"select f.FolioFactura from facturasaporta as f inner join cobros as c on f.IdFolioAporta = c.IdFolioAporta where c.NumeroPDD = '".$_POST["numPDD"]."'"); 
        $myrow=mysqli_fetch_array($r);
        $folio = $myrow[0];

        $r=mysqli_query($enlace,"select a.Concepto from tipoaportacion as a inner join facturasaporta as f on f.IdTipoAportacion = a.IdTipoAportacion where FolioFactura = '".$folio."'"); 
        $myrow=mysqli_fetch_array($r);
        $aportacion = mb_strtolower($myrow[0]);
        
        $to = $correo;
        $from = $correoContador;
        $fromName = 'AWOCOCADO';

        /////////////////////////////// mensaje ///////////////////////////////////

        if ($aportacion == "cuota"){
            $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

            $r=mysqli_query($enlace,"select * from facturasaporta where FolioFactura = '".$folio."'"); 
            $myrow=mysqli_fetch_array($r);
            $anioF = substr($myrow[4], 0 ,4);
            $mesF = substr($myrow[4], 5 ,2);

            if (($mesF-1) == 0){
                $mes = 11;
                $anio = $anioF - 1;
            } else{
                $mes = $mesF - 1;
                $anio = $anioF;
            }

            ///////////////// asunto /// 
            $subject = 'ENVIO DE FACTURA DE PAGO DIFERIDO DEL MES DE '.strtoupper($meses[$mesF-1]).' DEL AÑO '.$anioF; 
            ///////////////// mensaje ///
            $htmlContent = "<p>Buen día,<br><br>
            Adjunto factura de pago diferido No. ".$_POST["numPDD"]." correspondiente a: Cuota por Acopio del mes de ".strtoupper($meses[$mesF-1])." de ".$anioF.".<br><br>
            Sin más por el momento quedo a sus ordenes.<br><br>
            Atte Lcp. María Hernández</p>";
        } else{
            $r=mysqli_query($enlace,"select Concepto from facturasaporta where FolioFactura = '".$folio."'"); 
            $myrow=mysqli_fetch_array($r);
            $concepto = $myrow[0];

            ///////////////// asunto ///
            $subject = 'ENVIO DE FACTURA DE PAGO DIFERIDO AWOCOCADO'; 
            ///////////////// mensaje ///
            $htmlContent = "<p>Buen día,<br><br>
            Adjunto factura de pago diferido No. ".$_POST["numPDD"]." correspondiente a: ".$concepto.".<br><br>
            Sin más por el momento quedo a sus ordenes.<br><br>
            Atte Lcp. María Hernández</p>";
        }
        $htmlContent .= demoFooter();         

        $boundary = md5(time());
        $headers = "MIME-Version: 1.0\r\n"."From: $fromName"." <".$from.">\r\n"."Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n"; 
        $message = "--$boundary\r\n"."Content-Type: text/html; charset=UTF-8\r\n"."Content-Transfer-Encoding: base64\r\n\r\n".chunk_split(base64_encode($htmlContent));
        
        ////////////////////////////////// adjuntos /////////////////////////////////

        if (file_exists("Cobros/CobrosPDF/"."p".$_POST["numPDD"].".pdf")){
            $filePDF = "Cobros/CobrosPDF/"."p".$_POST["numPDD"].".pdf";
        } else{
            if (file_exists("Cobros/CobrosPDF/"."e".$_POST["numPDD"].".pdf")){
                $filePDF = "Cobros/CobrosPDF/"."e".$_POST["numPDD"].".pdf";
            }
        }
        if (file_exists("Cobros/CobrosXML/"."p".$_POST["numPDD"].".xml")){
            $fileXML = "Cobros/CobrosXML/"."p".$_POST["numPDD"].".xml";
        } else{
            if (file_exists("Cobros/CobrosXML/"."e".$_POST["numPDD"].".xml")){
                $fileXML = "Cobros/CobrosXML/"."e".$_POST["numPDD"].".xml";
            }
        }
        
        ////////////////////////////// PDF /////////////////////////////////////
        if(!empty($filePDF) > 0){
            if(is_file($filePDF)){
                $message .= "--$boundary\r\n";
                $fp =    @fopen($filePDF,"rb");
                $data =  @fread($fp,filesize($filePDF));
                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: application/octet-stream; name=\"".basename($filePDF)."\"\n" . 
                "Content-Description: ".basename($filePDF)."\n" .
                "Content-Disposition: attachment;\n" . " filename=\"".basename($filePDF)."\"; size=".filesize($filePDF).";\n" . 
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
        
        ////////////////////////////// XML /////////////////////////////////////
        if(!empty($fileXML) > 0){
            if(is_file($fileXML)){
                $message .= "--$boundary\r\n";
                $fp =    @fopen($fileXML,"rb");
                $data =  @fread($fp,filesize($fileXML));
                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: application/octet-stream; name=\"".basename($fileXML)."\"\n" . 
                "Content-Description: ".basename($fileXML)."\n" .
                "Content-Disposition: attachment;\n" . " filename=\"".basename($fileXML)."\"; size=".filesize($fileXML).";\n" . 
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
        $message .= "--$boundary--\r\n";
        $returnpath = "-f" . $from;

        ////////////////////////////////// envio /////////////////////////////////

        if (demoEmail($to, $nombreEmp, $htmlContent) == 1){
            $mail = @mail($to, $subject, $message, $headers, $returnpath); 
            $resultado = $mail?"1":"2";
        
            if ($resultado == 1){
                if (file_exists("Cobros/CobrosPDF/"."p".$_POST["numPDD"].".pdf")){
                    rename ("Cobros/CobrosPDF/"."p".$_POST["numPDD"].".pdf", "Cobros/CobrosPDF/"."e".$_POST["numPDD"].".pdf");
                }
            
                if (file_exists("Cobros/CobrosXML/"."p".$_POST["numPDD"].".xml")){
                    rename ("Cobros/CobrosXML/"."p".$_POST["numPDD"].".xml", "Cobros/CobrosXML/"."e".$_POST["numPDD"].".xml");
               }
            }
            echo $resultado;
        } else {
            echo 2;
        }
    }
    
    if ($id == 'cargarCobro'){
        $nom = "p".$_POST['numPDD'];

        $archivo = $_FILES['archivo'];
        $nombrefile = $_FILES['archivo']['name'];
        $rutatmp = $_FILES['archivo']['tmp_name'];
        $extension = pathinfo($nombrefile, PATHINFO_EXTENSION);
        $rutanueva = $_SERVER['DOCUMENT_ROOT'].'/Cobros/'."Cobros".$_POST['ext']."/".$nom.".".$extension;

        if(is_uploaded_file($rutatmp)) {
            if(copy($_FILES["archivo"]["tmp_name"], $rutanueva)){
                echo "1";
            }
        }
    }
    
    if ($id == 'gasto') {
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace, 'select IdFolioGasto from facturasgastos where factura = "'.$_POST['factura'].'" and IdProveedor = "'.$_POST['proveedor'].'"');
            $myrow=mysqli_fetch_array($r);
            
            if (@$myrow[0] == '') {
                $fact = 0;
                $acus = 0;
                
                //Calcular el IdFolio para guardar los archivos
                $r=mysqli_query($enlace, 'select MAX(IdFolioGasto) + 1 FROM facturasgastos');
                $row=mysqli_fetch_array($r);
                $nom = $row[0];
                
                if (@$_FILES['facturaPDF']['name'] != "") {
                    //$nom = $myrow[0];
                    $rutatmp = $_FILES['facturaPDF']['tmp_name'];
                    $rutanueva = "archivos/facturas/".$nom.".pdf";
        
                    if(is_uploaded_file($rutatmp)) {
                       if(copy($rutatmp, $rutanueva)){
                            $fact = "1";
                        } 
                    }
                } else {
                    $fact = 1;
                }
                
                if (@$_FILES['acusePDF']['name'] != "") {
                    //$nom = $myrow[0];
                    $rutatmp = $_FILES['acusePDF']['tmp_name'];
                    $rutanueva = "archivos/acuse/".$nom.".pdf";
        
                    if(is_uploaded_file($rutatmp)) {
                       if(copy($rutatmp, $rutanueva)){
                            $acus = "1";
                        } 
                    }
                } else {
                    $acus = 1;
                }
                
                if ($fact == 1 && $acus == 1) {
                    //Extraer el IdPuesto del autorizador
                    //select IdPuesto from autoriza where IdAutoriza = 1;
                    $r=mysqli_query($enlace, 'select IdPuesto from autoriza where IdAutoriza = "'.$_POST['autoriza'].'"');
                    $row=mysqli_fetch_array($r);
                    $puesto = $row[0];
                    
                    $conexion->beginTransaction();
                    //Registrar Gasto
                    $conexion->query("insert into facturasgastos values (null,'".$_POST['proveedor']."', '".$_POST['area']."', '".$_POST['autoriza']."', '".$puesto."','".$_POST['factura']."', '".$_POST['fechaFactura']."', '".$_POST['fechaSolicitud']."', null, '".$_POST['cantidad']."', '".$_POST['concepto']."', '".$_POST['estatus']."', '".$_POST['mesPago']."', '".$_POST['saldo']."', '".$_POST['observaciones']."')");
                    $conexion->commit();
                    
                    //Actualizar saldo de proveedor saldo++
                    $conexion->query("update proveedores SET Saldo =  Saldo + '".$_POST['saldo']."' WHERE IdProveedor = '".$_POST['proveedor']."'");
                    $conexion->commit();
                    
                    //Actualizar total de proveedor total++
                    $conexion->query("update proveedores SET Total = Total + '".$_POST['saldo']."' WHERE IdProveedor = '".$_POST['proveedor']."'");
                    $conexion->commit();
                    echo 1;
                } else {
                    echo 3;
                }
                
            } else {
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 4;
           
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Facturas Gastos", "Admin", "Error al insertar una nueva factura de gastos", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'proveedor') {
        try {
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace, 'select IdProveedor from proveedores where Nombre = "'.$_POST['nombre'].'"');
            $myrow=mysqli_fetch_array($r);
            
            if (@$myrow[0] == '') {
                $const = 0;
                $cuenta = 0;
                
                //Calcular el IdProveedor para guardar los archivos
                $r=mysqli_query($enlace, 'select MAX(IdProveedor) + 1 FROM proveedores');
                $myrow=mysqli_fetch_array($r);
                $nom = $myrow[0];
                
                if (@$_FILES['constanciaPDF']['name'] != "") {
                    $rutatmp = $_FILES['constanciaPDF']['tmp_name'];
                    $rutanueva = "archivos/constancia/".$nom.".pdf";
        
                    if(is_uploaded_file($rutatmp)) {
                       if(copy($rutatmp, $rutanueva)){
                            $const = "1";
                        } 
                    }
                } else {
                    $const = 1;
                }
                
                if (@$_FILES['edoCuentaPDF']['name'] != "") {
                    $rutatmp = $_FILES['edoCuentaPDF']['tmp_name'];
                    $rutanueva = "archivos/cuentas/".$nom.".pdf";
        
                    if(is_uploaded_file($rutatmp)) {
                       if(copy($rutatmp, $rutanueva)){
                            $cuenta = "1";
                        } 
                    }
                } else {
                    $cuenta = 1;
                }
                
                if ($const == 1 && $cuenta == 1) {
                    $conexion->beginTransaction();
                    //Iserción bancos
                    $conexion->query("insert into bancos values (null, '".$_POST['banco']."', '".$_POST['cuenta']."', '".$_POST['clabe']."', 'P', null, null)");
                    $conexion->commit();
            
                    //Buscar IdBanco
                    $r=mysqli_query($enlace,"select MAX(IdBanco) FROM bancos"); 
                    $myrow=mysqli_fetch_array($r);

                    //Insertar Proveedor
                    $conexion->query("insert into proveedores values (null, '".($myrow[0])."', '".$_POST['regimen']."', '".$_POST['nombre']."', '".$_POST['RFC']."', '".$_POST['pais']."', '".$_POST['estado']."', '".$_POST['ciudad']."', '".$_POST['domicilio']."', '".$_POST['CP']."', 0, 0)");
                    $conexion->commit();  
                    
                    echo 1;
                } else {
                    echo 3;
                }
            } else {
                echo 2;
            }             
        } catch (Exception $e){
            $conexion->rollback();
            echo 4;
          /*  
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Proveedores", "", "'.$conexion->errorCode().'", "Error al insertar un nuevo proveedor", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);*/
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'modificarProveedor') {
        try {
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);

            /*$r=mysqli_query($enlace, 'select IdProveedor from proveedores where Nombre = "'.$_POST['nombre'].'"');
            $myrow=mysqli_fetch_array($r);
            $pro = $_POST['idProveedor'];
            
            if (@$myrow[0] == $pro) {*/
                //$conexion->beginTransaction();
                //Banco
                $r=mysqli_query($enlace, 'select IdBanco from bancos where IdNombreBanco = "'.$_POST['banco'].'" AND NumCuenta = "'.$_POST['cuenta'].'" AND Clabe = "'.$_POST['clabe'].'"');
                $myrow=mysqli_fetch_array($r);
                
                $banco = '';
                
                $conexion->beginTransaction();
                if (@$myrow[0] == '') {
                    //Registrar nuevo banco
                    $conexion->query("insert into bancos values (null, '".$_POST['banco']."', '".$_POST['cuenta']."', '".$_POST['clabe']."', 'P', null, null)");
                    $conexion->commit();
                    
                    //Buscar IdBanco
                    $r=mysqli_query($enlace,"select MAX(IdBanco) FROM bancos"); 
                    $row=mysqli_fetch_array($r);
                    $banco = $row[0];
                } else {
                    //No se modifico el banco
                    $banco = $_POST['banco'];
                }
                
                //Actualizar proveedor
                $conexion->query("update proveedores SET IdBanco = '".$banco."', IdRegimen = '".$_POST['regimen']."', Nombre = '".$_POST['nombre']."', RFC = '".$_POST['RFC']."', Pais = '".$_POST['pais']."', Estado = '".$_POST['estado']."', Ciudad = '".$_POST['ciudad']."', Domicilio = '".$_POST['direccion']."', CP = '".$_POST['CP']."' WHERE IdProveedor = '".$_POST['idProveedor']."'");
                $conexion->commit();
                
                echo 1;
            /*} else {
                echo 2;
            }*/
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Proveedores", "Admin", "'.$conexion->errorCode().'", "Error al modificar un proveedor", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'pagarGasto') {
        try {
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace, 'select IdProveedor from facturasgastos where IdFolioGasto = "'.$_POST['folio'].'"');
            $row=mysqli_fetch_array($r);
            $proveedor = $row[0];
            
            $r=mysqli_query($enlace, 'select IdBanco from proveedores where IdProveedor = "'.$proveedor.'"');
            $row=mysqli_fetch_array($r);
            $banco = $row[0];
            
            $acuse = 0;

            //Calcular el IdPago para guardar los archivos
            $r=mysqli_query($enlace, 'select MAX(IdPago) + 1 FROM pagos');
            $myrow=mysqli_fetch_array($r);
            $nom = $myrow[0];
                
            /*if (@$_FILES['acusePDF']['name'] != "") {
                $archivo = $_FILES['acusePDF'];
                $nombrefile = $_FILES['acusePDF']['name'];
                $rutatmp = $_FILES['acusePDF']['tmp_name'];
                $rutanueva = $_SERVER['DOCUMENT_ROOT']."/archivos/acusePago/".$nom.".pdf";
        
                if(is_uploaded_file($rutatmp)) {
                   if(copy($rutatmp, $rutanueva)){
                        $acuse = "1";
                    } 
                }
            } else {
                $acuse = 1;
            }*/
            
            if (@$_FILES['acusePDF']['name'] != "") {
                    $rutatmp = $_FILES['acusePDF']['tmp_name'];
                    $rutanueva = "archivos/acusePago/".$nom.".pdf";
        
                    if(is_uploaded_file($rutatmp)) {
                       if(copy($rutatmp, $rutanueva)){
                            $acuse = "1";
                        } 
                    }
                } else {
                    $acuse = 1;
                }
                
                
            if ($acuse == 1) {
                $conexion->beginTransaction();
                //Iserción en pagos
                $conexion->query("insert into pagos values (null, '".$_POST['folio']."', '".$proveedor."', '".$banco."', '".$_POST['cuentaOri']."', '".$_POST['fecha']."', '".$_POST['monto']."', '".$_POST['modoPago']."', '".$_POST['referencias']."', '".$_POST['observaciones']."')");
                $conexion->commit();
            
                //Actualizar Saldo Factura
                $conexion->query("update facturasgastos set Saldo = Saldo - '".$_POST['monto']."' WHERE IdFolioGasto = '".$_POST['folio']."'");
                $conexion->commit();
                
                //Actualizar Saldo Proveedor
                $conexion->query("update proveedores set Saldo = Saldo - '".$_POST['monto']."' WHERE Idproveedor = '".$proveedor."'");
                $conexion->commit(); 
                
                //Actualizar Estatus Factura
                $conexion->query("update facturasgastos set Estatus = 'Pagada' WHERE saldo = 0");
                $conexion->commit();  
                    
                echo 1;
            } else {
                echo 3;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 4;
          /*  
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Proveedores", "", "'.$conexion->errorCode().'", "Error al insertar un nuevo proveedor", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);*/
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'modAutoriza') {
        try {
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);
        
            $conexion->beginTransaction();
            $conexion->query("update autoriza SET IdPuesto = '".$_POST['puesto']."', Activo = '".$_POST['activo']."', FechaActivo = NOW() where IdAutoriza = '".$_POST['nombre']."'");
            $conexion->commit();
            echo 1;
        } catch (Exception $e){
            $conexion->rollback();
            echo 2;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Autorizador", "Admin", "'.$conexion->errorCode().'", "Error al modificar un autorizador", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'cuotas'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from cuotas where Cantidad = "'.$_POST['cantidad'].'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $r=mysqli_query($enlace,'select * from cuotas where Fecha = "'.$_POST['fecha'].'"'); 
                $myrow=mysqli_fetch_array($r);
                if (@$myrow[0] == ''){
                    $conexion->beginTransaction();
                        $conexion->query('insert into cuotas values (null,"'.$_POST['cantidad'].'","'.$_POST['fecha'].'")');
                    $conexion->commit();
                    echo 1;
                } else{
                    echo 3;
                }
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Cuotas", "'.$_POST['usuario'].'", "Error al registrar una nueva cuota", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'regimen'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,'select * from regimen where Codigo = "'.$_POST['codigo'].'"' ); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $r=mysqli_query($enlace,'select * from regimen where lower(Concepto) = "'.mb_strtolower($_POST['regimen']).'"' ); 
                $myrow=mysqli_fetch_array($r);
                if (@$myrow[0] == ''){
                    $conexion->beginTransaction();                                        
                        $conexion->query('insert into regimen values (null, "'.$_POST['codigo'].'", "'.$_POST['regimen'].'")');
                    $conexion->commit();
                    echo 1;
                } else{
                    echo 4;
                }
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Régimen Fiscal", "", "Error al registrar el régimen fiscal '.$_POST['regimen'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'autoriza'){
        $r=mysqli_query($enlace,"select Nombre from autoriza where Nombre = '".$_POST['nombre']."'"); 
        $myrow=mysqli_fetch_array($r);
        if (@$myrow[0] == ''){
            $sql = 'insert into autoriza values (null, "'.$_POST['puesto'].'", "'.$_POST['nombre'].'", 1, NOW())';
            mysqli_query($enlace,$sql);
            echo 1;
        } else{
            echo 2;
        }
    }
 
    if ($id == 'proveedores'){
       try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO
                ::ATTR_AUTOCOMMIT, 0);

            $conexion->beginTransaction();
            
            //Verificar que no exista otro igual
            $r=mysqli_query($enlace,"select * from proveedores where Nombre = '".$_POST['nombre']."'"); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                //Iserción bancos
                $conexion->query("insert into bancos values (null, '".$_POST['banco']."', '".$_POST['cuenta']."', '".$_POST['clabe']."')");
                $conexion->commit();
            
                //Buscar IdBanco
                $r=mysqli_query($enlace,"select IdBanco from bancos ORDER BY IdBanco DESC"); 
                $myrow=mysqli_fetch_array($r);

                //Insertar Proveedor
                $conexion->query("insert into proveedores values (null, '".($myrow[0])."', '".$_POST['regimen']."', '".$_POST['nombre']."', '".$_POST['RFC']."', '".$_POST['pais']."', '".$_POST['estado']."', '".$_POST['ciudad']."', '".$_POST['domicilio']."', '".$_POST['CP']."', 0, 0)");
                $conexion->commit();  
            
            echo 1;
            } else {
                echo 2;
            }   
        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Proveedores", "", "'.$conexion->errorCode().'", "Error al registrar un nuevo proveedor", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
            echo 3;
        } finally{
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'autorizar') {
        $sql = "update facturasgastos SET Estatus = 'Autorizada' where idfoliofactura = '".$_POST['idFactura']."'";
        mysqli_query($enlace,$sql);
    }
    
    if ($id == 'cargarGasto'){
        $nom = $_POST['folio'];
        $rutatmp = $_FILES['archivo']['tmp_name'];
        $rutanueva = "archivos/facturas/".$nom.".pdf";
        
        if(copy($rutatmp, $rutanueva)){
            echo "1";
        }
    }
    
    if ($id == 'cargarAcuse'){
        $nom = $_POST['folio'];
        $rutatmp = $_FILES['archivo']['tmp_name'];
        $rutanueva = "archivos/acuse/".$nom.".pdf";
        
        if(copy($rutatmp, $rutanueva)){
            echo "1";
        }
    }
    
    if ($id == 'cargarConstancia'){
        $nom = $_POST['folio'];
        $rutatmp = $_FILES['archivo']['tmp_name'];
        $rutanueva = "archivos/constancia/".$nom.".pdf";
        
        if(copy($rutatmp, $rutanueva)){
            echo "1";
        }
    }
    
    if ($id == 'cargarEdoCuenta'){
        $nom = $_POST['folio'];
        $rutatmp = $_FILES['archivo']['tmp_name'];
        $rutanueva = "archivos/cuentas/".$nom.".pdf";
        
        if(copy($rutatmp, $rutanueva)){
            echo "1";
        }
    }
    
    if ($id == 'usuarios'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            
            $r=mysqli_query($enlace,"select * from usuarios where Correo = '".$_POST['correo']."' LIMIT 1"); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $r=mysqli_query($enlace,'select * from usuarios where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'" LIMIT 1'); 
                $myrow=mysqli_fetch_array($r);
                if (@$myrow[0] == ''){
                    require "funciones.php";
                    $url = 'Login/templateRestPassword.php';
                    $mensajeTem = "Para poder ingresar al Sistema AWOCOCADO es necesario que actives tu cuenta por medio del enlace que se muestra o pulsando el botón de abajo.";
                    $boton = "Activar cuenta";

                    $codigo = bin2hex(random_bytes(25));
                    $r=mysqli_query($enlace,"SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$bdA."' AND   TABLE_NAME   = 'usuarios';"); 
                    $myrow=mysqli_fetch_array($r);

                    if (sendEmail($_POST['correo'], $_POST['nombre'], $codigo, $myrow[0], $url, $mensajeTem, $boton, false)){
                        $conexion->beginTransaction();
                            $conexion->query('insert into usuarios (`IdUsuario`, `IdTipoUsuario`, `Nombre`, `Correo`, `Contrasena`, `CodigoPassword`, `SolicitudPassword`) values (null, "'.$_POST['tipoU'].'", "'.$_POST['nombre'].'", "'.$_POST['correo'].'", "'.bin2hex(random_bytes(16)).'", "'.$codigo.'", 1)');
                        $conexion->commit();
                        echo 1;
                    }
                } else{
                    echo 2;
                }
            } else{
                echo 3;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 4;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Usuarios", "'.$_POST['usuario'].'", "Error al registrar el usuario '.$_POST['nombre'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    function regUsuarioEmp($correo, $nombre){
        global $enlace;
        global $conexion;
        global $bdA;
        $r=mysqli_query($enlace,"select * from usuarios where Correo = '".$correo."' LIMIT 1"); 
            $myrow=mysqli_fetch_array($r);
        if (@$myrow[0] == ''){
            $r=mysqli_query($enlace,'select * from usuarios where lower(Nombre) = "'.mb_strtolower($nombre).'" LIMIT 1'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                require "funciones.php";
                $url = 'Login/templateRestPassword.php';
                $mensajeTem = "Para poder ingresar al Sistema AWOCOCADO es necesario que actives tu cuenta por medio del enlace que se muestra o pulsando el botón de abajo.";
                $boton = "Activar cuenta";
                $codigo = bin2hex(random_bytes(25));

                $r=mysqli_query($enlace,"select IdTipoUsuario from tipousuario where Descripcion = 'Empaque' LIMIT 1"); 
                $myrow=mysqli_fetch_array($r);
                $tipoUsuario = $myrow[0];

                $r=mysqli_query($enlace,"SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$bdA."' AND   TABLE_NAME   = 'usuarios';"); 
                $myrow=mysqli_fetch_array($r);

                if (sendEmail($_POST['correo'], $_POST['nombre'], $codigo, $myrow[0], $url, $mensajeTem, $boton, false)){
                    $conexion->query('insert into usuarios (`IdUsuario`, `IdTipoUsuario`, `Nombre`, `Correo`, `Contrasena`, `CodigoPassword`, `SolicitudPassword`) values (null, "'.$tipoUsuario.'", "'.$nombre.'", "'.$_POST['correo'].'", "'.bin2hex(random_bytes(16)).'", "'.$codigo.'", 1)');
                    return 1;
                } else{
                    return 3;
                }
            } else{
                return 4;
            }
        } else{
            return 5;
        }
    }
    
    if ($id == 'modEstatusCanFacAporta'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $conexion->beginTransaction();
                $conexion->query("update facturasaporta SET Estatus = 'Cancelada' WHERE FolioFactura = '".$_POST['folio']."'");

                $r=mysqli_query($enlace,"select e.Saldo, f.IdFolioAporta from empacadora as e inner join facturasaporta as f on f.IdEmpacadora = e.IdEmpacadora where f.FolioFactura = '".$_POST["folio"]."'");
                $myrow=mysqli_fetch_array($r); 
                $conexion->query("update empacadora as e inner join facturasaporta as f on f.IdEmpacadora = e.IdEmpacadora SET e.Saldo = '".($myrow[0] - doubleval(str_replace(",", "", $_POST['total'])))."' WHERE f.FolioFactura = '".$_POST['folio']."'");
                
                $conexion->query('insert into cancelacionaporta values (null, "'.$myrow[1].'", DATE(CONVERT_TZ(NOW(),"+00:00","-06:00")), "'.$_POST['justificacion'].'")');
            $conexion->commit();
            echo "1";
        } catch (Exception $e){
            $conexion->rollback();
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Facturas empacadoras", "'.$_POST['usuario'].'", "Error al cancelar la factura con folio '.$_POST['folio'].'", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'modOficial'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace,'select * from expedidorcfi where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'" AND IdExpedidorCFI <> "'.$_POST['idOficial'].'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('update expedidorcfi SET Nombre = "'.$_POST['nombre'].'" where IdExpedidorCFI = "'.$_POST['idOficial'].'"');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Oficiales", "'.$_POST['usuario'].'", "Error al modificar el nombre de un oficial", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'modTerceria'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace,'select * from tercerias where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'" AND IdTerceria <> "'.$_POST['idTerceria'].'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('update tercerias SET Nombre = "'.$_POST['nombre'].'" where IdTerceria = "'.$_POST['idTerceria'].'"');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Tercerías", "'.$_POST['usuario'].'", "Error al modificar una tercería", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'modTE'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace,'select * from terceroespecialista where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'" AND IdTerceroEspecialista <> "'.$_POST['idTE'].'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('update terceroespecialista SET Nombre = "'.$_POST['nombre'].'" where IdTerceroEspecialista = "'.$_POST['idTE'].'"');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Terceros especialistas", "'.$_POST['usuario'].'", "Error al modificar el nombre de un TEF", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    if ($id == 'modPuerto'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $r=mysqli_query($enlace,'select * from regulaciones where lower(Nombre) = "'.mb_strtolower($_POST['nombre']).'" AND IdRegulacion <> "'.$_POST['idPuerto'].'"'); 
            $myrow=mysqli_fetch_array($r);
            if (@$myrow[0] == ''){
                $conexion->beginTransaction();
                    $conexion->query('update regulaciones SET Nombre = "'.$_POST['nombre'].'" where IdRegulacion = "'.$_POST['idPuerto'].'"');
                $conexion->commit();
                echo 1;
            } else{
                echo 2;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 3;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Puertos de entrada", "'.$_POST['usuario'].'", "Error al modificar el nombre de un puerto", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }

    if ($id == 'modCuentaBancaria'){
        try{
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

            $banderaB = false;
            ////////////////////////// verificación de clabe y Num Cuenta
            if ($_POST['cuenta'] != ""){
                $r=mysqli_query($enlace,'select * from bancos where lower(NumCuenta) = "'.mb_strtolower($_POST['cuenta']).'" AND IdBanco <> "'.$_POST['idBanco'].'"'); 
                $myrow=mysqli_fetch_array($r);
                if (@$myrow[0] != ''){
                    $banderaB = true;
                    echo 2;
                }
            }
            if ($_POST['clabe'] != ""){
                $r=mysqli_query($enlace,'select * from bancos where Clabe = "'.$_POST['clabe'].'" AND IdBanco <> "'.$_POST['idBanco'].'"'); 
                $myrow=mysqli_fetch_array($r);
                if (@$myrow[0] != ''){
                    $banderaB = true;
                    echo 3;
                }
            }

            if ($banderaB == false){
                $conexion->beginTransaction();
                    $conexion->query('update bancos SET NumCuenta = "'.strtoupper($_POST['cuenta']).'", Clabe = "'.$_POST['clabe'].'" where IdBanco = "'.$_POST['idBanco'].'"');
                $conexion->commit();
                echo 1;
            }
        } catch (Exception $e){
            $conexion->rollback();
            echo 4;
            $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Cuentas bancarias", "'.$_POST['usuario'].'", "Error al modificar una cuenta bancaria", "'.$e->getMessage().'")';
            mysqli_query($enlaceBitacora,$sql);
        } finally{
            $conexion->setAttribute(PDO ::ATTR_AUTOCOMMIT,1);
            $conexion->connection = null;
        }
    }
    
    function enviarCorreo($data, $size, $nombre, $subject, $htmlContent, $to, $nombreEmp){
        global $correoContador;
        require "funciones.php";
        
        $from = $correoContador;
        $fromName = 'AWOCOCADO';
        $htmlContent .= demoFooter();

        $boundary = md5(time());
        $headers = "MIME-Version: 1.0\r\n"."From: $fromName"." <".$from.">\r\n"."Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n"; 
        $message = "--$boundary\r\n"."Content-Type: text/html; charset=UTF-8\r\n"."Content-Transfer-Encoding: base64\r\n\r\n".chunk_split(base64_encode($htmlContent));
        
        ////////////////////////////////// adjunto /////////////////////////////////

        $message .= "--$boundary\r\n";
        $message .= "Content-Type: application/octet-stream; name=\"".$nombre."\"\n" . 
        "Content-Description: ".$nombre."\n" .
        "Content-Disposition: attachment;\n" . " filename=\"".$nombre."\"; size=".$size.";\n" . 
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        $message .= "--$boundary--\r\n";
        $returnpath = "-f" . $from;

        ////////////////////////////////// envio /////////////////////////////////
        
        if (demoEmail($to, $nombreEmp, $htmlContent) == 1){
            $mail = @mail($to, $subject, $message, $headers, $returnpath); 
            return $mail?"1":"4";
        } else{
            return 4;
        }
    }
?>