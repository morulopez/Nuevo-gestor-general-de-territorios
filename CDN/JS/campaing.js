class campaing{
	constructor(url){
		this.url = url;
	}
	req_campaing(){
		fetch(`${this.url}/Campaings/req_campaing`,{
		    headers:{
		     'Accept':'application/JSON',
		     'Content-Type':'application/x-www-form-urlencoded'  
		    }
		}).then(res=>{
			res.json().then(resp=>{
				console.log(resp);
				document.getElementById('listdatapubli').innerHTML+=`<div class="row firstline">
		          <div class="col-md-3">Nombre de campaña:</div>
		          <div class="col-md-3">Fecha de apertura:</div>
		          <div class="col-md-3">Fecha de cierre:</div>
		         </div>`;
		         var activa ="";
		         var exitcamactive = false;
		         for(var key in resp){
		         	if(resp[key].activa==1){
		         		activa = '<span class="spanactivo">Activa</span><i class="fas fa-check"></i>';
		         		exitcamactive = true;
		         	}else{
		         		activa = '<span class="spancerrado">Cerrada</span><i class="fas fa-times spancerrado"></i>';
		         	}
		         	document.getElementById('listdatapubli').innerHTML+=`<div class="row linea" id="primerdiv">
		            <div class="col-md-3">${resp[key].nombre_campaing}</div>
		            <div class="col-md-3">${resp[key].fecha_apertura}</div>
		            <div class="col-md-3">${resp[key].fecha_cierre} ${activa}</div>
		            <div class="col-md-3"><a href="#modal_info_campaing"><button type="button" onclick="Campaing.req_info_campaing('${resp[key].ID}');" class="btn btn-outline-info botonver"><i class="fas fa-eye"></i>Datos de campaña</button></a></div>
		           </div>`;
		         }
		         document.getElementById('crearcampaingfirst').addEventListener("click",()=>{
		         	if(exitcamactive){
						Swal.fire({
			            type: 'warning',
			            title: 'Tienes una campaña en activo',
			            text: 'Para crear una campaña nueva tienes que terminar y desactivar la campaña que tienes activada',
			          }).then( ()=> document.getElementById('cerrar-modal').click())
					}
				})
		        document.getElementById('crearcampaing').addEventListener("click",()=>{
					if(exitcamactive){
						Swal.fire({
			            type: 'warning',
			            title: 'Tienes una campaña en activo',
			            text: 'Para crear una campaña nueva tienes que terminar y desactivar la campaña que tienes activada',
			          })
					}else{
						this.crear_campaing();
					}
				})
			})
		})
	}
	crear_campaing(){
		var form=document.getElementById('formcampaing');
		let array = ["nombre","inicio","cierre","observaciones"];
		const obj = {};
		for(var i=0;i<=form.length-2;i++){
			if(form[i].value==''){
				return 
			}
			obj[array[i]]=form[i].value;
		}
		fetch(`${this.url}/Campaings/nueva_campaing`,{
			method:"POST",
		    body:JSON.stringify(obj),
		    headers:{
		     'Accept':'application/JSON',
		     'Content-Type':'application/x-www-form-urlencoded'  
		    }
		}).then(res=>{
			res.json().then(resp=>{
				if(resp){

				}
			})
		})
	}
	req_info_campaing(id){
		fetch(`${this.url}/Campaings/req_info_campaing`,{
			method:"POST",
		    body:`id=${id}`,
		    headers:{
		     'Accept':'application/JSON',
		     'Content-Type':'application/x-www-form-urlencoded'  
		    }
		}).then(resp=>{
			resp.json().then(respuesta=>{
				console.log(respuesta);
				 document.getElementById('show_info_campaing').innerHTML= respuesta.vista;
				document.getElementById('grafico').addEventListener('click',()=>{
					document.getElementById('chair').style.display='block';
					var porhacer=respuesta.datosnumber-respuesta.datospredicados;
					var porcentajeecho = respuesta.datospredicados*100/respuesta.datosnumber;
					var resto = 100-porcentajeecho;
					document.getElementById('porcentajes').innerHTML=`<div class="row" style="margin-bottom:20px;">
						<div class="col-md-6 text-left">
							<span class='spanestadoterri'>Trabajo realizado:</span> <span class='spanestadoterri positivo'>${Math.round(porcentajeecho)}%</span>
						</div>
						<div class="col-md-6 text-left">
						    <span class='spanestadoterri'>Trabajo por realizar:</span> <span class='spanestadoterri negativo'>${Math.round(resto)}%</span>
						</div>
					</div>`;
					this.generar_grafico(respuesta.datospredicados,porhacer);
				})
			})
			
		}).catch(err=> console.log(err));
	}
	show_terri(){
		document.getElementById('showterri').style.display='block';
	}
	generar_grafico(predicados,sinpredicar){
		var data = {
				datasets: [{
				    data: [predicados,sinpredicar],
				    backgroundColor: [
				        'rgba(38, 194, 129, 1)',
				        'rgba(231, 76, 60, 1)',
				    ],
				}],
				    // These labels appear in the legend and in the tooltips when hovering different arcs
				labels: [
				    `Territorios completados ${predicados}`,
				    `Por completar ${sinpredicar}`
				]
		};		
		var ctx = document.getElementById('myChart').getContext('2d');
				  var myDoughnutChart = new Chart(ctx, {
						type: 'doughnut',
						data: data,
						options:{}
				});
	}
	remove_grafico(id){
		document.getElementById(id).style.display="none";
	}
	borrarcampaing(id,estado){
		if(estado){
			return Swal.fire({
			type: 'warning',
			title: 'Tienes territorios asignados que estan trabajandose',
			text: 'Para borrar una campaña tienes que devolver todos los territorios asignados',
			})
		}
		
	}
	desactivarcampaing(id,estado){
		if(estado){
			return Swal.fire({
			type: 'warning',
			title: 'Tienes territorios asignados que estan trabajandose',
			text: 'Para desactivar una campaña tienes que devolver todos los territorios asignados, de esta forma se llevará mejor el control de todos los territorios',
			})
		}
		fetch(`${this.url}/Campaings/desactivar_campaing`,{
			method:"POST",
		    body:`id=${id}`,
		    headers:{
		     'Accept':'application/JSON',
		     'Content-Type':'application/x-www-form-urlencoded'  
		    }
		}).then(resp=>{
			resp.json().then(respuesta=>{
				Swal.fire({
				type: 'success',
				title: 'Campaña desactivada',
				}).then(()=>{
					this.req_info_campaing(id);
					document.getElementById('listdatapubli').innerHTML="";
					this.req_campaing();

				})
			})
		})
	}
}