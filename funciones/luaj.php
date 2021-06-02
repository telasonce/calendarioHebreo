<?php

include $_SERVER['DOCUMENT_ROOT'] . "/public/plugins/adodb-time.inc.php";















 define('moladano1jalakim', 204); define('moladano1hora', 5); define('moladano1dia', 2);
 define('restojalakim19', 595); define('restohoras19', 16); define('restodias19', 2);
 define('restojalakimpeshuta', 876); define('restohoraspeshuta', 8); define('restodiaspeshuta', 4);
 define('restojalakimmeuberet', 589); define('restohorasmeuberet', 21); define('restodiasmeuberet', 5);
 define('restojalakimmes', 793); define('restohorasmes', 12); define('restodiasmes', 1);
 define('cantdiasmajzor', 6939); define('canthorasmajzor', 16); define('cantjalakimmajzor', 595);
 define('cantdiasanopeshuta', 354); define('canthorasanopeshuta', 8); define('cantjalakimanopeshuta', 876);
 define('cantdiasanomeuberet', 383); define('canthorasanomeuberet', 21); define('cantjalakimanomeuberet', 589);
 define('diaRHano0solar', 20); define('mesRHano0solar', 10); 
 define('diasRHano0hasta1ene1', 72); define('horasRHano0hasta1ene1', 22); define('jmRHano0hasta1ene1', 1005);
 
 
    //dim $fechaactual $As $ddmmaa;
 
    //----------
 
function esbisiestosolar($AnoSolar) {
        if (floor($AnoSolar / 4) * 4 == $AnoSolar) {
            return  true;
        } else {
            return  false;
        }
    }
 
function tipo_de_ano($ANO) {
 
        //-----------------------
        //Calculo diferencia entre Dia R H
        // ano calculado y el siguiente
        $Dia_RH = Dia_de_RoshHaShana($ANO);
        $Dia_RH_Sig = Dia_de_RoshHaShana($ANO + 1);
		
        if ($Dia_RH_Sig <= $Dia_RH) {
			$Dia_RH_Sig = $Dia_RH_Sig + 7;
        }

        $Difer = ($Dia_RH_Sig - $Dia_RH) - 1;
		
		
        //-----------------------
        $Meuberet = EsBisiesto($ANO);
				
		
        if (!$Meuberet) {
			
			switch($Difer) {
			
				case 2:
					$Tipo = 0;
					break;
				case 3:
					$Tipo = 1;
					break;
				case 4:
					$Tipo = 2;
					break;
			
			}
            
        } else {

			switch($Difer) {
			
				case 4:
					$Tipo = 0;
					break;
				case 5:
					$Tipo = 1;
					break;
				case 6:
					$Tipo = 2;
					break;
			
			}
        }
  
  return  $Tipo;
 
    }
 
function molad_del_ano($AnoaCalcular,&$jalakim,&$HORA,&$DIA) {
 
        $cantmajzorim = floor(($AnoaCalcular - 1) / 19);
        $restoanos19 = fmod(($AnoaCalcular - 1), 19);
        //----------
        $cantbisiestos = CantidadBisiestos($restoanos19);
        $cantnobisiestos = $restoanos19 - $cantbisiestos;
        //----------
 
        $totalrestosjalakim19 = $cantmajzorim * restojalakim19;
        $totalrestoshoras19 = $cantmajzorim * restohoras19;
        $totalrestosdias19 = $cantmajzorim * restodias19;

        //----------
        $totalrestosjalakimnobisiestos = $cantnobisiestos * restojalakimpeshuta;
        $totalrestoshorasnobisiestos = $cantnobisiestos * restohoraspeshuta;
        $totalrestosdiasnobisiestos = $cantnobisiestos * restodiaspeshuta;
        //----------
        $totalrestosjalakimbisiestos = $cantbisiestos * restojalakimmeuberet;
        $totalrestoshorasbisiestos = $cantbisiestos * restohorasmeuberet;
        $totalrestosdiasbisiestos = $cantbisiestos * restodiasmeuberet;
        //----------
        $totaljalakimbuscados = $totalrestosjalakim19 + $totalrestosjalakimnobisiestos + $totalrestosjalakimbisiestos;
        $totalhorasbuscadas = $totalrestoshoras19 + $totalrestoshorasnobisiestos + $totalrestoshorasbisiestos;
        $totaldiasbuscados = $totalrestosdias19 + $totalrestosdiasnobisiestos + $totalrestosdiasbisiestos;
 
        Convertir($totaljalakimbuscados, $totalhorasbuscadas, $totaldiasbuscados);
        //----------
        $moladanobuscadojalakim = moladano1jalakim + $totaljalakimbuscados;
        $moladanobuscadohora = moladano1hora + $totalhorasbuscadas;
        $moladanobuscadodia = moladano1dia + $totaldiasbuscados;
        //----------
        Convertir($moladanobuscadojalakim, $moladanobuscadohora, $moladanobuscadodia);
        $difermoladbuscadodia_y_ano1 = $moladanobuscadodia - moladano1dia;
        $restodifer = fmod($difermoladbuscadodia_y_ano1, 7);
        $moladanobuscadodia = fmod(($restodifer + moladano1dia - 1), 7 ) + 1;
        //---------- se asignan valores a las variables a devolver -----
        $jalakim = $moladanobuscadojalakim;
        $HORA = $moladanobuscadohora;
        $DIA = $moladanobuscadodia;
    }
 
function Dia_de_RoshHaShana($ANO) {
        //dim $jm;
        //dim $HORA;
        //dim $DIA;
        //dim $meuberet_este_ano;
        //dim $meuberet_ano_anterior;
 
        molad_del_ano($ANO, $jm, $HORA, $DIA);
		
        $meuberet_este_ano = EsBisiesto($ANO);
        $meuberet_ano_anterior = EsBisiesto($ANO - 1);
		
		$diaBuscado = $DIA;

		switch($diaBuscado){
            			
			Case 1:
			Case 4:
			Case 6:
                $diaBuscado = $diaBuscado + 1;
				return  $diaBuscado;
			}			



		
		if ($HORA >= 18) {
					
			if ($DIA == 7)
			{
				$diaBuscado = 1;
			}else
			{
				$diaBuscado = $diaBuscado + 1;
			}
			
		}

		switch($diaBuscado){
            			
			Case 1:
			Case 4:
			Case 6:
                $diaBuscado = $diaBuscado + 1;
				return  $diaBuscado;	
		}			

		
		
		if ($DIA==3){
			if ($HORA > 9 || ($HORA == 9 && $jm >= 204)){
				if (!$meuberet_este_ano){
					$diaBuscado = 5;
				}	
			}
		}
        
		
		if ($DIA==2){
			if ($HORA > 15 || ($HORA == 15 && $jm >= 589)){
				if ($meuberet_ano_anterior){
					$diaBuscado = 3;
				}	
			}
		}
		
		
        return  $diaBuscado;
    
} 
function Molad_del_ano_siguiente($anoaincrementar,&$moladanosiguientejalakim,&$moladanosiguientehora,&$moladanosiguientedia) {
        //dim $AnoaCalcular;
        //dim $jmactual;
        //dim $horaactual;
        //dim $diaactual;
        //dim $jsig;
        //dim $hsig;
        //dim $dsig;
 
        if (EsBisiesto($AnoaCalcular) == true) {
            $moladanosiguientejalakim = $jmactual + restojalakimmeuberet;
            $moladanosiguientehora = $horaactual + restohorasmeuberet;
            $moladanosiguientedia = $diaactual + restodiasmeuberet;
        } else {
            $moladanosiguientejalakim = $jmactual + restojalakimpeshuta;
            $moladanosiguientehora = $horaactual + restohoraspeshuta;
            $moladanosiguientedia = $diaactual + restodiaspeshuta;
        }
        $jsig = $moladanosiguientejalakim;
        $hsig = $moladanosiguientehora;
        $dsig = $moladanosiguientedia;
        Convertir($jsig, $hsig, $dsig);
        $dsig = fmod(($dsig - 1), 7) + 1;
        $moladanosiguientejalakim = $jsig;
        $moladanosiguientehora = $hsig;
        $moladanosiguientedia = $dsig;
    }
 
function Convertir(&$jm,&$hs,&$ds) {
        $hs = $hs + floor($jm / 1080);
        $jm = fmod($jm, 1080);
        $ds = $ds + floor($hs / 24);
        $hs = fmod($hs,24);
    }
 
function EsBisiesto($anoaevaluar) {
        $resto = fmod($anoaevaluar,19);
		
        if ($resto == 0) {
			$valor=true;
        } else {
			
			switch($resto){
				
				Case 3:
				Case 6:
				Case 8:
				Case 11:
				Case 14:
				Case 17:
					$valor=true;
					break;
				
				Case 1:
				Case 2:
				Case 4:
				Case 5:
				Case 7:
				Case 9:
				Case 10:
				Case 12:
				Case 13:
				Case 15:
				Case 16:
				Case 18:
					$valor=false;
					
					break;

			}
			
        }
	
		return $valor;
    }
 
function CantidadBisiestos($numerodeanos) {

        if ($numerodeanos == 0) {
            return  0;
        } else {
			
			switch($numerodeanos){
            
				Case 1: 
				Case 2:
					$valor=0;
					break;
				
				Case 3:
				Case 4:
				Case 5:
					$valor=1;
					break;
					
				Case 6:
				Case 7:
					$valor=2;
					break;
		
				Case 8:
				Case 9:
				Case 10:
					$valor=3;
					break;
					
				Case 11:
				Case 12:
				Case 13:
					$valor=4;
					break;

				Case 14:
				Case 15:
				Case 16:
					$valor=5;
					break;

				Case 17: 
				Case 18:
					$valor=6;
					break;

				Case 19:
					$valor=7;
					break;



					}
			
            return  $valor;
			
        }
    }
 
function Cant_dias_de_un_ano($ANOLUNAR) {
        //dim $CantDias;
        //dim $Meuberet;
        //dim $Tipo;
        $Meuberet = EsBisiesto($ANOLUNAR);
        $Tipo = tipo_de_ano($ANOLUNAR);
        if ($Meuberet) {
            $CantDias = 383;
        } else {
            $CantDias = 353;
        }
        $CantDias = $CantDias + $Tipo;
        return  $CantDias;
    }
 
function CantMesesUnAnoLunar($Meuberet) {
		if (!$Meuberet){
			$valor = 12;
		}
		else {
			$valor = 13;
		}
	
        return  $valor;
    }
 
function calculo_dia_RH_solar($ANOLUNAR,&$DiaSolar,&$MesSolar,&$AnoSolar) {
 
        //dim $anolun;
        //dim $AnoBase;
        //dim $TotDias;
        //dim $FechaRH $As Date;
 
        $AnoBase = 5549;
        $TotDias = 0;
		
        for ($anolun=$AnoBase; $anolun<=$ANOLUNAR - 1; $anolun++) { 
			$TotDias = $TotDias + Cant_dias_de_un_ano($anolun);
			
        }
		
        //---------------------------------------------------
        //    Se calculan cuantos dias pasaron desde
        //    el 1 ene -3759 hasta 1 ene del ano buscado
		
		
		$A=1788;
		$M=10;
		$D=2;
		
		$t = adodb_mktime(12,10,0,$M,$D,$A);
	
		$suma = $t + $TotDias * 86400;
		
		
        $DiaSolar = adodb_date("d", $suma);
        $MesSolar = adodb_date("m", $suma);
        $AnoSolar = adodb_date("Y", $suma);
    }
	
function NombreMesLunar($MESLUNAR, $Meuberet) {
	if (!$Meuberet) {
		
		switch($MESLUNAR) {
			
			case 1:
				$valor = "TISHRE";
				break;
			case 2:
				$valor = "JESHVAN";
				break;
			case 3:
				$valor = "KISLEV";
				break;
			case 4:
				$valor = "TEVET";
				break;
			case 5:
				$valor = "SHEVAT";
				break;
			case 6:
				$valor = "ADAR";
				break;
			case 7:
				$valor = "NISAN";
				break;
			case 8:
				$valor = "IAR";
				break;
			case 9:
				$valor = "SIVAN";
				break;
			case 10:
				$valor = "TAMUZ";
				break;
			case 11:
				$valor = "AV";
				break;
			case 12:
				$valor = "ELUL";
				break;	
			}
	} 
	else
	{
		
		switch($MESLUNAR) {
			
			case 1:
				$valor = "TISHRE";
				break;
			case 2:
				$valor = "JESHVAN";
				break;
			case 3:
				$valor = "KISLEV";
				break;
			case 4:
				$valor = "TEVET";
				break;
			case 5:
				$valor = "SHEVAT";
				break;
			case 6:
				$valor = "ADAR ALEF";
				break;
			case 7:
				$valor = "ADAR BET";
				break;	
			case 8:
				$valor = "NISAN";
				break;
			case 9:
				$valor = "IAR";
				break;
			case 10:
				$valor = "SIVAN";
				break;
			case 11:
				$valor = "TAMUZ";
				break;
			case 12:
				$valor = "AV";
				break;
			case 13:
				$valor = "ELUL";
				break;
					
		}			
            
    }
	return $valor;
}
 

 
function NOMBREMESSOLAR($MesSolar) {
	switch($MesSolar) {
			
			case 1:
				$valor = "Enero";
				break;
			case 2:
				$valor = "Febrero";
				break;
			case 3:
				$valor = "Marzo";
				break;
			case 4:
				$valor = "Abril";
				break;
			case 5:
				$valor = "Mayo";
				break;
			case 6:
				$valor = "Junio";
				break;
			case 7:
				$valor = "Julio";	
				break;
			case 8:
				$valor = "Agosto";
				break;
			case 9:
				$valor = "Septiembre";
				break;
			case 10:
				$valor = "Octubre";
				break;
			case 11:
				$valor = "Noviembre";
				break;
			case 12:
				$valor = "Diciembre";
				break;
					
		}
		return $valor;
        
    }
 
function NombreDiaDeSemanaSolar($DIADESEMANA) {
	switch($DIADESEMANA) {
			
			case 1:
				$valor = "Domingo";
				break;
			case 2:
				$valor = "Lunes";
				break;
			case 3:
				$valor = "Martes";
				break;
			case 4:
				$valor = "Miercoles";
				break;
			case 5:
				$valor = "Jueves";
				break;
			case 6:
				$valor = "Viernes";
				break;
			case 7:
				$valor = "Sabado";
				break;
					
		}
		return $valor;

    }
 
function CantDiasUnMesLunar($MESLUNAR, $Meuberet, $TipoDeAno) {
        if ($TipoDeAno==0 || $TipoDeAno==1){
			$Jeshvan = 29;
		}
		else {
			$Jeshvan = 30;
		}
		
		if ($TipoDeAno==1 || $TipoDeAno==2){
			$Kislev = 30;
		}
		else {
			$Kislev = 29;
		}
	
  
        if ($Meuberet) {
			switch($MESLUNAR){
		
			Case 1:
			Case 5:
			Case 6:
			Case 8:
			Case 10:
			Case 12:
				$valor = 30;
				break;
			
			Case 4:
			Case 7:
			Case 9:
			Case 11:
			Case 13:
				$valor = 29;
				break;
				
			Case 2:
				$valor = $Jeshvan;
				break;
				
			Case 3:
				$valor = $Kislev;
				break;
			}

		} else {
			switch($MESLUNAR){
		
			Case 1:
			Case 5:
			Case 7:
			Case 9:
			Case 11:
				$valor = 30;
				break;
			
			Case 4:
			Case 6:
			Case 8:
			Case 10:
			Case 12:
				$valor = 29;
				break;
				
			Case 2:
				$valor = $Jeshvan;
				break;
				
			Case 3:
				$valor = $Kislev;
				break;
			}
            
        }
		return $valor;
    }
 
function ObtenerFechaLunarSegunSolar($DiaSolar, $MesSolar, $AnoSolar,&$DIALUNAR,&$MESLUNAR,&$ANOLUNAR) {
        //dim $FechaRHsolar $As Date;
        //dim $FechaRHsolar_Ant $As Date;
        //dim $DiaSol_Ant;
        //dim $MesSol_Ant;
        //dim $AnoSol_Ant;
        //dim $FechaRHsolar_Sig $As Date;
        //dim $DiaSol_Sig;
        //dim $MesSol_Sig;
        //dim $AnoSol_Sig;
        //dim FechaSolarBuscada $As Date;
        //dim $AnoLunar_Sig;
        //dim $DiasTransc; //Contiene cuantos dias pasaros desde
        // RH hasta fecha buscada
        //dim CantDiasSegunSolar; //idem diastransc, pero le sumo
        // una unidad para que de cant dias netos
 
 
 
        //-------------------------
        // Obtencion del ano Lunar
 
        $ANOLUNAR = $AnoSolar + 3760;
        $AnoLunar_Sig = $ANOLUNAR + 1;
 
 
        calculo_dia_RH_solar($AnoLunar_Sig, $DiaSol_Sig, $MesSol_Sig, $AnoSol_Sig);
 
 
		$FechaRHsolar_Sig = adodb_mktime(12,10,0,$MesSol_Sig,$DiaSol_Sig,$AnoSol_Sig); 
		
		$FechaSolarBuscada = adodb_mktime(12,10,0,$MesSolar,$DiaSolar,$AnoSolar);

		 
        if ($FechaSolarBuscada >= $FechaRHsolar_Sig) {
            $ANOLUNAR = $AnoLunar_Sig;
            $FechaRHsolar = $FechaRHsolar_Sig;
        } else {
            calculo_dia_RH_solar($ANOLUNAR, $DiaSol_Ant, $MesSol_Ant, $AnoSol_Ant);
			
			$FechaRHsolar_Ant = adodb_mktime(12,10,0,$MesSol_Ant,$DiaSol_Ant,$AnoSol_Ant);
	
            $FechaRHsolar = $FechaRHsolar_Ant;
			
        }
 
        //------------------------
        //Obtencion del mes Lunar
 
        $Meuberet = EsBisiesto($ANOLUNAR);
        $TipoDeAno = tipo_de_ano($ANOLUNAR);
 
		$segundosTransc = $FechaSolarBuscada - $FechaRHsolar;
		
		$DiasTransc = $segundosTransc / 86400;


		$DiasTransc = abs($DiasTransc); $DiasTransc = floor($DiasTransc);
 
        $CantDiasSegunSolar = $DiasTransc + 1;
		
		$S_MesLunar = 1;
		
		$CantDiasUnMes = CantDiasUnMesLunar($S_MesLunar, $Meuberet, $TipoDeAno);
		
        $SumaDias = $CantDiasUnMes;
        
        While ($SumaDias < $CantDiasSegunSolar){

			$S_MesLunar = $S_MesLunar + 1;
            $CantDiasUnMes = CantDiasUnMesLunar($S_MesLunar, $Meuberet, $TipoDeAno);
			
            $SumaDias = $SumaDias + $CantDiasUnMes;
        }
 
        $MESLUNAR = $S_MesLunar;
 
        //------------------------
        //Obtencion del dia Lunar
 
		$DiferCantDias = $SumaDias - $CantDiasSegunSolar;
        $DIALUNAR = $CantDiasUnMes - $DiferCantDias;
    }
 
function ObtenerFechaSolarSegunLunar($DIALUNAR, $MESLUNAR, $ANOLUNAR,&$DiaSolar,&$MesSolar,&$AnoSolar) {
        //dim $Meuberet;
        //dim $TipoDeAno;
        //dim $CantDiasMes;
        //dim $SumaDias;
        //dim $DiasTransc;
        //dim $S_MesLunar;
        //dim $CantDiasUnMes;
        //dim $FecSol $As $ddmmaa;
        //dim $FechaRHsolar $As Date;
        //dim FechaSolarBuscada $As Date;
 
        //Calculo Cantdias de este mes
        // y el mes anterior
 
        $Meuberet = EsBisiesto($ANOLUNAR);
        $TipoDeAno = tipo_de_ano($ANOLUNAR);
        $CantDiasMes = CantDiasUnMesLunar($MESLUNAR, $Meuberet, $TipoDeAno);
 
        // Calculo cuantos dias pasaros desde
        // principio de ano
 
        $SumaDias = 0;
        $S_MesLunar = 0;
        While ($S_MesLunar < $MESLUNAR){
            $S_MesLunar = $S_MesLunar + 1;
            $CantDiasUnMes = CantDiasUnMesLunar($S_MesLunar, $Meuberet, $TipoDeAno);
            $SumaDias = $SumaDias + $CantDiasUnMes;
        }
        $DiasTransc = $SumaDias - ($CantDiasMes - $DIALUNAR) - 1;
 
        calculo_dia_RH_solar($ANOLUNAR, $DiaSolarRH, $MesSolarRH, $AnoSolarRH);
		
        $FechaRHsolar = date_create('$AnoSolarRH/$MesSolarRH/$DiaSolarRH');
		$FechaSolarBuscada = date('Y-m-d', strtotime($FechaRHsolar. ' + $DiasTransc'));
 
        $DiaSolar = Day($FechaSolarBuscada);
        $MesSolar = Month($FechaSolarBuscada);
        $AnoSolar = Year($FechaSolarBuscada);
    }

 
function Fecha1EsMayorIgualFecha2($DiaLunar1, $MesLunar1, $AnoLunar1, $DiaLunar2, $MesLunar2, $AnoLunar2) {
        return  false;
        if ($AnoLunar1 > $AnoLunar2) {
            return  true;
        } else {
            if ($AnoLunar1 == $AnoLunar2) {
                if ($MesLunar1 > $MesLunar2) {
                    return  true;
                } else {
                    if ($MesLunar1 == $MesLunar2) {
                        if ($DiaLunar1 >= $DiaLunar2) {
                            return  true;
                        }
                    }
                }
            }
        }
    }
 
?>