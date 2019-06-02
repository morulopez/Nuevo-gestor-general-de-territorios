/*** 
Objeto datos usuario,territorios publicadores etc con este objeto obtenemos los datos 
***/

class dataUser{
  constructor(url,id,numpage){
    this.url      = url;
    this.id       = id;
    this.numpage  = numpage;
  }
  /**
  Esta funcion (dataUserAdmin())la llamamos desde la vista mi_perfil.php y con ella mostramos el dato del 
  administrador de la correspondiente congregacion
  **/
  dataUserAdmin(){
    let obj = {"id": this.id};
    fetch(`${this.url}/Publicadores/datos_admin`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( data => {
      data.json().then(datos =>{document.getElementById('listdata').innerHTML=`<ul class="list-group listaperfil">
          <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Nombre:</div><div class="col-md-6 col-sm-6 col-6 datos" id="id_nombre">${datos.userdata.nombre}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_nombre" title="Actualizar datos" onclick="ReqDatos.update('${datos.userdata.nombre}','id_nombre')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_nombre" style="display:none">Actualizar</button></div></div></li>
          <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Apellidos:</div><div class="col-md-6 col-sm-6 col-6 datos" id="id_apellidos">${datos.userdata.apellidos}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_apellidos" title="Actualizar datos" onclick="ReqDatos.update('${datos.userdata.apellidos}','id_apellidos')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_apellidos" style="display:none">Actualizar</button></div></div></li>
          <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Email:</div><div class="col-md-6 col-sm-6 col-6 datosemail" id="id_email">${datos.userdata.email}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_email" title="Actualizar datos" onclick="ReqDatos.update('${datos.userdata.email}','id_email')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_email" style="display:none">Actualizar</button></div></div></li>
          <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Nombre Congregación:</div> <div class="col-md-6 col-6 col-sm-6 datos" id="id_nombre_congregacion">${datos.userdata.nombre_congregacion}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_nombre_congregacion" title="Actualizar datos" onclick="ReqDatos.update('${datos.userdata.nombre_congregacion}','id_nombre_congregacion')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_nombre_congregacion" style="display:none">Actualizar</button></div></div></li>
          <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Provincia:</div><div class="col-md-6 col-sm-6 col-6 datos" id="id_provincia">${datos.userdata.provincia}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_provincia" title="Actualizar datos" onclick="ReqDatos.update('${datos.userdata.provincia}','id_provincia')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_provincia" style="display:none">Actualizar</button></div></div></li>
          <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Localidad:</div><div class="col-md-6 col-sm-6 col-6 datos" id="id_localidad">${datos.userdata.localidad}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_localidad" title="Actualizar datos" onclick="ReqDatos.update('${datos.userdata.localidad}','id_localidad')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_localidad" style="display:none">Actualizar</button></div></div></li>
          </ul>`;
          datos.years_services.map(dat => {
             document.querySelector(".selectyear").innerHTML+=`<option id="${dat.ID}" value="${dat.ID}">Año de servicio:  ${dat.year}</option>`;
             if(dat.activo) this.dataservice(dat.ID);

          });
        });
      document.querySelector(".selectyear").innerHTML+=`<option id="8" value="8">Año de servicio:  17-18</option>`;
    });
  }
  dataservice(id){
    document.getElementById("yearselect").addEventListener("change",(e) =>{
      return this.dataserviciechange(e.target.value);
    });
    fetch(`${this.url}/Publicadores/datos_service`,{
      method:"POST",
      body:`id=${id}`,
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( data => {
        data.json().then(datos=>{
          document.querySelector(".datosservice").innerHTML ="";
      document.getElementById('porcentajes').innerHTML ="";
      document.querySelector(".fir").innerHTML = "";
       document.getElementById('porcentajes').innerHTML = `<div class="row">
              <div class="col-md-3 text-center">
                <h5>Grafica</h5>
              </div>
            </div>`;
      document.querySelector(".fir").innerHTML =`<div class='row titlerowfirst'>
        <div class='col-md-3 text-left'>
          <span class='spanestadotitle'>Numero:</span>
        </div>
        <div class='col-md-3 text-left'>
          <span class='spanestadotitle'>Zona:</span>
        </div>
        <div class='col-md-3 text-left'>
          <span class='spanestadotitle'>Asignado:</span>
        </div>
        <div class='col-md-3 text-left'>
          <span class='spanestadotitle'>Estado:</span>
        </div>
      </div>`;
          console.log(datos);
          var active;
          datos.datos.activo ? active = '<span class="spanactivo">Activo</span><i class="fas fa-check"></i>' : active = '<span class="spancerrado">Cerrada</span><i class="fas fa-times spancerrado"></i>'; 
          document.querySelector(".datosservice").innerHTML = `<div class="row">
            <div class="col-md-4">
              Año de servicio: <span class='spanestadoterri'>${datos.datos.year}</span>
            </div>
            <div class="col-md-4">
              Estado : ${active}
            </div>
            <div class="col-md-4">
              Cierre de año: <span class='spanestadoterri'>${datos.datos.fecha_cierre}</span>
            </div>
          </div>
          <div class="row">
          <div class="col-md-4">
              Territorios para predicar: <span class='spanestadoterri'>${datos.datos.numero_territorios}</span>
            </div>
            <div class="col-md-4">
              Predicados : <span class='spanestadoterri'>${datos.datos.territorios_predicados}</span>
            </div>
          </div>` ;
          datos.control.map(datos=>{
            var asignado;
            var predicado;
            if(datos.predicado){
              asignado="ya trabajado";
              predicado = '<span class="spanactivo">Predicado</span><i class="fas fa-check"></i>';
            }else{
              predicado ='<span class="spancerrado">Sin predicar</span><i class="fas fa-times spancerrado"></i>';
              asignado = "Sin asignar";
            }
            if(datos.nombre){
              asignado  = datos.nombre+" "+datos.apellidos;
              predicado = '<span class="proceso">Trabajandose</span><i class="fas fa-walking trabajandose"></i>';
            }
            document.querySelector(".fir").innerHTML+=`<div class='first'>
          <div class='row divstateterri tableyear'>
            <div class='col-md-3 text-left'>
              <span class='spanestadoterri'>${datos.numero_territorio}</span>
            </div>
            <div class='col-md-3 text-left' style="text-transform:capitalize;">
                <span class='spanestadoterri'>${datos.zona}</span>
            </div>
            <div class='col-md-3 text-left' style="text-transform:capitalize;">
               <span class='spanestadoterri'>${asignado}</span>
            </div>
            <div class='col-md-3 text-left' style="text-transform:capitalize;">
                <span class='spanestadoterri'>${predicado}</span>
            </div>
          </div>
        </div>`;
          });
          var porhacer=datos.numero_territorios-datos.predicados;
          var porcentajeecho = datos.predicados*100/datos.numero_territorios;
          var resto = 100-porcentajeecho;
          document.getElementById('porcentajes').innerHTML+=`<div class="row" style="margin-bottom:20px;">
            <div class="col-md-6 text-center">
              <span class='spanestadoterri'>Trabajo realizado:</span> <span class='spanestadoterri positivo'>${Math.round(porcentajeecho)}%</span>
            </div>
            <div class="col-md-6 text-center">
                <span class='spanestadoterri'>Trabajo por realizar:</span> <span class='spanestadoterri negativo'>${Math.round(resto)}%</span>
            </div>
          </div>`;
          this.generar_grafico(datos.predicados,porhacer);
        })
    });
  }
  dataserviciechange(id){
   fetch(`${this.url}/Publicadores/datos_service`,{
      method:"POST",
      body:`id=${id}`,
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( data => {
        data.json().then(datos=>{
          console.log(datos);
          document.querySelector(".datosservice").innerHTML ="";
          document.getElementById('porcentajes').innerHTML ="";
          document.querySelector(".fir").innerHTML = "";
          document.getElementById('porcentajes').innerHTML = `<div class="row">
              <div class="col-md-3 text-center">
                <h5>Grafica</h5>
              </div>
            </div>`;
          document.querySelector(".fir").innerHTML =`<div class='row titlerowfirst'>
          <div class='col-md-3 text-left'>
            <span class='spanestadotitle'>Numero:</span>
          </div>
          <div class='col-md-3 text-left'>
            <span class='spanestadotitle'>Zona:</span>
          </div>
          <div class='col-md-3 text-left'>
            <span class='spanestadotitle'>Asignado:</span>
          </div>
          <div class='col-md-3 text-left'>
            <span class='spanestadotitle'>Estado:</span>
          </div>
        </div>`;
          var active;
          datos.datos.activo ? active = '<span class="spanactivo">Activo</span><i class="fas fa-check"></i>' : active = '<span class="spancerrado">Cerrada</span><i class="fas fa-times spancerrado"></i>'; 
          document.querySelector(".datosservice").innerHTML = `<div class="row">
            <div class="col-md-4">
              Año de servicio: <span class='spanestadoterri'>${datos.datos.year}</span>
            </div>
            <div class="col-md-4">
              Estado : ${active}
            </div>
            <div class="col-md-4">
              Cierre de año: <span class='spanestadoterri'>${datos.datos.fecha_cierre}</span>
            </div>
          </div>
          <div class="row">
          <div class="col-md-4">
              Territorios para predicar: <span class='spanestadoterri'>${datos.datos.numero_territorios}</span>
            </div>
            <div class="col-md-4">
              Predicados : <span class='spanestadoterri'>${datos.datos.territorios_predicados}</span>
            </div>
          </div>` ;
          datos.control.map(datos=>{
            var asignado;
            var predicado;
            if(datos.predicado){
              asignado="ya trabajado";
              predicado = '<span class="spanactivo">Predicado</span><i class="fas fa-check"></i>';
            }else{
              predicado ='<span class="spancerrado">Sin predicar</span><i class="fas fa-times spancerrado"></i>';
              asignado = "Sin asignar";
            }
            if(datos.nombre){
              asignado  = datos.nombre+" "+datos.apellidos;
              predicado = '<span class="proceso">Trabajandose</span><i class="fas fa-walking trabajandose"></i>';
            }
            document.querySelector(".fir").innerHTML+=`<div class='first'>
          <div class='row divstateterri tableyear'>
            <div class='col-md-3 text-left'>
              <span class='spanestadoterri'>${datos.numero_territorio}</span>
            </div>
            <div class='col-md-3 text-left' style="text-transform:capitalize;">
                <span class='spanestadoterri'>${datos.zona}</span>
            </div>
            <div class='col-md-3 text-left' style="text-transform:capitalize;">
               <span class='spanestadoterri'>${asignado}</span>
            </div>
            <div class='col-md-3 text-left' style="text-transform:capitalize;">
                <span class='spanestadoterri'>${predicado}</span>
            </div>
          </div>
        </div>`;
          });
          var porhacer=datos.numero_territorios-datos.predicados;
          var porcentajeecho = datos.predicados*100/datos.numero_territorios;
          var resto = 100-porcentajeecho;
          document.getElementById('porcentajes').innerHTML+=`<div class="row" style="margin-bottom:20px;">
            <div class="col-md-6 text-center">
              <span class='spanestadoterri'>Trabajo realizado:</span> <span class='spanestadoterri positivo'>${Math.round(porcentajeecho)}%</span>
            </div>
            <div class="col-md-6 text-center">
                <span class='spanestadoterri'>Trabajo por realizar:</span> <span class='spanestadoterri negativo'>${Math.round(resto)}%</span>
            </div>
          </div>`;
          this.generar_grafico(datos.predicados,porhacer);
        })
    });
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
   prue(){
    let obj = {"id": this.id};
    fetch(`${this.url}/Publicadores/datos_admin`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( data => {
      data.json().then(datos =>{
       datos.years_services.map(dat => {
        console.log(dat,"eeee");
       })
      });
    });
   }
  update(dato,id){
    /**
    esta funcion recoge los datos del html justo escrito aqui arriba y con 
    ella actualizamos los datos del administrador
    **/
   document.getElementById("boton_"+id).style.display = 'none';
   document.getElementById("actualizar_"+id).style.display = 'block';
   document.getElementById(id).innerHTML=`<input class="form-control" id="dato_${id}" value="${dato}">`;
   document.getElementById("actualizar_"+id).addEventListener("click",()=>{
    let obj = {};
    obj[id] = document.getElementById(`dato_${id}`).value
    fetch(`${this.url}/Publicadores/datos_update`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( dato_up => {
       dato_up.json().then(up =>{
        if(up == 'Email no valido'){
          return document.getElementById('erroremail').innerHTML=up;
        }
        if(up){
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'Actualizado correctamente'
          })
          document.getElementById('erroremail').innerHTML='';
          document.querySelector(".selectyear").innerHTML="";
          this.dataUserAdmin();
        }
       });
    })
   });
  }
  /**
  funcion para actualizar publicadores, esta funcion la llamamos desde la vista theme/info_pulicador
  **/
  update_publicador(dato,id,id_publicador){
   document.getElementById("boton_"+id).style.display = 'none';
   document.getElementById("actualizar_"+id).style.display = 'block';
   document.getElementById(`div_${id}`).innerHTML=`<input class="form-control" id="dato_${id}" value="${dato}">`;
   document.getElementById("actualizar_"+id).addEventListener("click",()=>{
    let obj = {};
    obj[id] = document.getElementById(`dato_${id}`).value;
    obj['id_publicador'] = id_publicador;
    fetch(`${this.url}/Publicadores/update_publicador`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( dato_up => {
       dato_up.json().then(up =>{
        //console.log(up);
        if(up === 'El email ya existe, escoja otro por favor' || up === 'Email no valido'){
          return document.getElementById('erroremail').innerHTML=up;
      
        }
        if(up){
           const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'Actualizado correctamente'
          })
          this.ver_publicador(id_publicador);
        }
       })
    })
   })
  }
  req_terri_asig(idservice){
    fetch(`${this.url}/Territorios/obtener_terri_asig`,{
      method:"POST",
      body:`idservice=${idservice}`,
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(res => {
      res.json().then(respuesta =>{
        document.getElementById('divasignarterri').style.display='block';
        document.getElementById('showterriservicio').innerHTML='';
        for(var i in respuesta){
          document.getElementById('showterriservicio').innerHTML+=`<option id="${respuesta[i].ID}" value="${respuesta[i].ID}">${respuesta[i].numero_territorio} ${respuesta[i].zona}</option>`;

        }
         this.mostrarpredicado(respuesta);
      });
    });
  }
  mostrarpredicado(obj){
    document.getElementById('showterriservicio').addEventListener('change',()=>{
      document.querySelector('#avi').style.display='none';
      for(var o in obj){
        if(obj[o].ID == document.getElementById('showterriservicio').value){
          if(obj[o].predicado==1){
            document.querySelector('#avi').style.display='block';
            return document.querySelector('#avi').innerHTML="Aviso de que este territorio se ha predicado ya en este año de servicio.Puedes asignarlo por que esta libre o asignar otros territorios que no se han predicado en este año todavia";
          }
        }
      }
    })

  }
  req_terri_asig_campaing(id){
    fetch(`${this.url}/Territorios/obtener_terri_asig_cam`,{
      method:"POST",
      body:`id=${id}`,
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(res => {
      res.json().then(respuesta =>{
        document.getElementById('showterricampaing').style.display='block';
        document.getElementById('showterriserviciocam').innerHTML='';
        for(var i in respuesta){
          document.getElementById('showterriserviciocam').innerHTML+=`<option id="camp${respuesta[i].ID}" value="${respuesta[i].ID}">${respuesta[i].numero_territorio} ${respuesta[i].zona}</option>`;
        }
      });
    });
  }
  closeasig(id){
     document.getElementById(id).style.display='none';
     document.querySelector('#avi').style.display='none';
  }
  observaciones_asig(){
    document.getElementById('modal-observaciones').innerHTML='';
    var id = document.getElementById('showterriservicio').value;
    fetch(`${this.url}/Territorios/observaciones_asig`,{
      method:"POST",
      body:`id=${id}`,
      headers:{
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(res=>{
      res.json().then(obser=>{
        if(obser === 'No hay resultados'){
          document.getElementById('modal-observaciones').innerHTML='<h5>Sin observaciones</h5>';
        }else{
           for(var i in obser){
              document.getElementById('modal-observaciones').innerHTML+=`<div class="divobservacionasig">${obser[i].observacion}</div>`;
           }
        }
      });
    });
  }
  asignarterritorio(id_publicador){
     let idterri  = document.getElementById('showterriservicio').value;
     let entrega  = document.getElementById('fechaentrega').value;
     let devuelta = document.getElementById('fechadevuelta').value;
     if( entrega =='' || devuelta ==''){
        document.getElementById('spanerror').style.display='block';
        return setInterval(()=>{ document.getElementById('spanerror').style.display='none'; }, 3000);
     }
     if(entrega > devuelta){
        document.getElementById('spanerror2').style.display='block';
        return setInterval(()=>{ document.getElementById('spanerror2').style.display='none'; }, 6000);
     }
     const obj = {
                  "idterri":idterri,
                  "id_publicador":id_publicador,
                  "entrega":entrega,
                  "devuelta":devuelta};
     fetch(`${this.url}/Publicadores/asignarterritorio`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(res=>{
      res.json().then(respuesta=>{
        if(respuesta){
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'Territorio asignado correctamente'
          })
          this.ver_publicador(id_publicador);
        }
      })
    })
  }
  asignarterritorio_campaing(idpublicador){
    let idterri  = document.getElementById('showterriserviciocam').value;
    let entrega  = document.getElementById('fechaentregacam').value;
    let devuelta = document.getElementById('fechadevueltacam').value;
    if( entrega =='' || devuelta ==''){
      document.getElementById('spanerrorcam').style.display='block';
      return setInterval(()=>{ document.getElementById('spanerrorcam').style.display='none'; }, 3000);
    }
    if(entrega > devuelta){
        document.getElementById('spanerror2cam').style.display='block';
        return setInterval(()=>{ document.getElementById('spanerror2cam').style.display='none'; }, 6000);
    }
     const obj = {
                  "idterri":idterri,
                  "id_publicador":idpublicador,
                  "entrega":entrega,
                  "devuelta":devuelta};
     fetch(`${this.url}/Publicadores/asignarterritorio_campaing`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(res=>{
      res.json().then(respuesta=>{
        if(respuesta){
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'Territorio de campaña asignado correctamente'
          })
          this.ver_publicador(idpublicador);
        }
      })
    })
  }
  devolver_territorio(numero,idterritorio,idpublicador,zona,id_service_year){
    const obj = {
      "numero_territorio":numero,
      "zona":zona,
      "idterritorio":idterritorio,
      "idpublicador":idpublicador,
      "id_service_year":id_service_year
    };
    fetch(`${this.url}/Publicadores/devolver_terri_servicio`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( resp=>{
      resp.json().then(response=>{
        if(response){
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'Territorio devuelto con exito'
          })
          this.ver_publicador(idpublicador);
        }
      })
    })
  }
  devolver_territorio_campaing(idcampaing,idterritorio,idpublicador){
    const obj = {
      "idcampaing": idcampaing,
      "idterritorio":idterritorio,
      "idpublicador":idpublicador
    };
    fetch(`${this.url}/Publicadores/devolver_territorio_campaing`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( resp=>{
      resp.json().then(response=>{
        if(response){
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'Territorio de campaña devuelto con exito'
          })
          this.ver_publicador(idpublicador);
        }
      })
    })
  }
  /**
  Recogemos los publicadores que pertenezcan a la congregacion,
  esta funcion la ejecutamos en la vista publicadores.php y mediante document.getElementById() insertamos el HTML
  **/
  req_publicadores(){
    let obj = {"numpage": this.numpage};
    fetch(`${this.url}/Publicadores/req_all_publicadores`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( data => {
      data.json().then(data => {
         document.getElementById('listdatapubli').innerHTML+=`<div class="row firstline">
          <div class="col-md-3">Nombre:</div>
          <div class="col-md-3 text-center">Apellidos:</div>
          <div class="col-md-6 text-right"><i class="fas fa-circle"></i><span class="spancumplido">Publicadores con territorios cumplidos</span></div>
         </div>`;
         var datos      = data.publicadores;
         var pagination = data.total_paginas;
         var id='';    
         var number = 0;
         var array= [];
         var arraydiv = [];
        for(var key in datos){
          var f = new Date();
          var mes=f.getMonth()+1;
          /*Aqui agregamos un cero a la izquierda para poder comparar fechas**/
          mes=("0" + mes).slice(-2);
          var year=f.getFullYear();
          var day=f.getDate();
          var clasealerta='';
            if(!array.includes(datos[key].id)){
              document.getElementById('listdatapubli').innerHTML+=`<div class="row linea" id="primerdiv${number}">
              <div class="col-md-4">${datos[key].nombre}</div>
              <div class="col-md-4 text-left">${datos[key].apellidos}</div>
              <div class="col-md-4"><a href="#modal_info_publicadores"><button type="button" onclick="ReqDatos.ver_publicador('${datos[key].id}');" class="btn btn-outline-info botonver"><i class="fas fa-eye"></i>Ver publicador</button></a></div>
             </div>`;
                 if(datos[key].id == datos[key].ID_publicador && datos[key].devuelta!=null){
                   if(year.toString()+"-"+mes.toString()+"-"+day.toString()>=datos[key].devuelta){
                    var indice = array.indexOf(datos[key].id);
                    document.getElementById(`primerdiv${number}`).classList.add("clasealer");
                    }
                  }
                if(datos[key].id == datos[key].ID_publicador_campaing && datos[key].devuelta_campaing!=null){
                   if(year.toString()+"-"+mes.toString()+"-"+day.toString()>=datos[key].devuelta_campaing){
                    var indice = array.indexOf(datos[key].id);
                    document.getElementById(`primerdiv${number}`).classList.add("clasealer");
                  }
                }
            }
            if(array.includes(datos[key].id) && datos[key].id == datos[key].ID_publicador && datos[key].devuelta!=null){
               if(year.toString()+"-"+mes.toString()+"-"+day.toString()>=datos[key].devuelta){
                var indice = array.indexOf(datos[key].id);
                document.getElementById(arraydiv[indice]).classList.add("clasealer");
              }
            }
            if(array.includes(datos[key].id) && datos[key].id == datos[key].ID_publicador_campaing && datos[key].devuelta_campaing!=null){
               if(year.toString()+"-"+mes.toString()+"-"+day.toString()>=datos[key].devuelta_campaing){
                var indice = array.indexOf(datos[key].id);
                document.getElementById(arraydiv[indice]).classList.add("clasealer");
              }
            }
          if(!array.includes(datos[key].id)){
            array[number] = datos[key].id;
            arraydiv[number] = `primerdiv${number}`;
          }
          id=datos[key].id;
          number++;
        }
        clasealerta='';
        for(var i=1;i<=pagination;i++){
            document.getElementById('paginationpubli').innerHTML+=`<a class="page-link" href="${this.url}/publicadores/${i}">${i}</a>`
        }
      });
    });
  }
  /**
  Funcion para llamar a la vista donde veremos a un publicador concreto
  **/
  ver_publicador(id){
    let obj={"id":id};
    fetch(`${this.url}/Publicadores/info_publicador`,{
       method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded' 
      }}).then( res => {
          res.json().then( respuesta => {
            document.getElementById('show_info_publicador').innerHTML= respuesta
          })
      })
  }
  /**
  con esta funcion buscamos a los publicadores que pertenezcan a la congregacion
  **/
  search_publicador(){
    
  }
  /** 
  Agregamos publicadores a cada congregacion.Esta funcion es llamada desde la vista publicadores.php.
  Al cargarse una ventana modal aparece el formulario para cargar los datos y el boton que ejecuta esta funcion
  **/
  agregar_Publicador(){
    let form  = document.getElementById('formpublicador');
    let obj   = {};
    for(var i = 0 ; i<form.elements.length-1;i++){
      if(form.elements[i].id == 'nombrepublicador' || form.elements[i].id == 'apellidospublicador'){
        if(document.getElementById(form.elements[i].id).value ==''){
          return document.getElementById('error').innerHTML='El nombre y apellidos son obligatorios';
        } 
      }
      document.getElementById('error').innerHTML='';
      obj[form.elements[i].id] = document.getElementById(form.elements[i].id).value;
    }
    fetch(`${this.url}/Publicadores/agregar_publicador`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(resp =>{
      resp.json().then(res=> {
        if(res === 'Email no valido'){
          return document.getElementById('error').innerHTML='El email no es valido';
        }
        if(res === 'El email ya existe por favor escoja otro'){
          document.getElementById('cerrar-modal').click();
          return Swal.fire({
            type: 'error',
            title: 'Este email ya existe, escoja otro por favor',
            text: '',
          })
        }
        if(!res){
          return
        }
        if(res){
          document.getElementById('cerrar-modal').click();
          Swal.fire({
            type: 'success',
            title: 'Publicador creado correctamente',
            text: 'El publicador se ha añadido correctamente',
          }).then(()=>{
            form.reset();
            document.getElementById('listdatapubli').innerHTML   ='';
            document.getElementById('paginationpubli').innerHTML ='';
            this.req_publicadores(this.numpage);
          });
        }
      });
    })
  }
  load_again_publicadores(){
     document.getElementById('listdatapubli').innerHTML='';
     document.getElementById('paginationpubli').innerHTML ='';
    this.req_publicadores();
  }
  borrarpublicador(id,asig,asigcampaing){
    if(asig && asig!="no asignado" || asigcampaing && asigcampaing!="no asignado campaing"){
       return Swal.fire({
              type: 'info',
              title: 'No puedes borrar este publicador',
              text: 'El publicador tiene territorios asignados y debes devolverlos antes de poder borrarlo',
            });
    }else{
      Swal.fire({
        title:`¿Está seguro de eliminar este publicador?`,
        html:'<button id="borrar" class="btn btn-danger alertborrar">'+
             'Borrar' +
             '</button>' +
             '<button id="noborrar" class="btn btn-warning alertnoborrar">' +
             'No borrar' +
             '</button>',
        showConfirmButton: false,
        onBeforeOpen:()=>{
        const borrar   = document.getElementById('borrar');
        const noborrar = document.getElementById('noborrar');
          borrar.addEventListener('click',()=>{
            fetch(`${this.url}/Publicadores/eliminar_publicador`,{
                method:"POST",
                body:`id=${id}`,
                headers:{
                  'Content-Type':'application/x-www-form-urlencoded' 
                }
            }).then(res=>{
              res.json().then(resp =>{
                console.log(resp);
                if(resp){
                const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });
                Toast.fire({
                  type: 'success',
                  title: 'Publicador borrado'
                });
                document.getElementById('cerrar-modal').click();
                document.getElementById('listdatapubli').innerHTML='';
                document.getElementById('paginationpubli').innerHTML='';
                this.req_territorios();
              }
              })
            })
          });
          noborrar.addEventListener('click',()=>{
            Swal.close();
          })
        }
      })
    }
  }
  filtrarterriasig(){
    if(document.getElementById('buscarterri').value==''){
      return document.getElementById('terrifiltrados').innerHTML="";
    }
    fetch(`${this.url}/Territorios/buscar_terri`,{
      method:"POST",
      body:JSON.stringify({"value":document.getElementById('buscarterri').value}),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(res=>{
      res.json().then(resp=>{
        document.getElementById('terrifiltrados').innerHTML="";
          if(resp.length<1){
            document.getElementById('terrifiltrados').innerHTML="<div class='divterrifil'>No hay resultados</div>";
          }
          var idterri="";
          for(var i in resp){
            if(idterri!=resp[i].ID){
              document.getElementById('terrifiltrados').innerHTML+=`<div class="divterrifil" onclick="ReqDatos.cambiarselect(${resp[i].ID},${resp[i].numero_territorio},'${resp[i].zona}')">Numero territorio: ${resp[i].numero_territorio} <span class="zo">zona:</span> ${resp[i].zona}</div>`;
            }
          idterri=resp[i].ID;
          }
      })
    })
  }
  /**ESTA FUNCION ES PARA FILTRAR LOS TERRITORIOS DE CAMPAÑA POR LAS OBSERVACIONES**/
  filtrarterriasigcamp(){
    if(document.getElementById('buscarterricamp').value==''){
      return document.getElementById('terrifiltradoscamp').innerHTML="";
    }
    fetch(`${this.url}/Territorios/buscar_terri`,{
      method:"POST",
      body:JSON.stringify({"value":document.getElementById('buscarterricamp').value}),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(res=>{
      res.json().then(resp=>{
        document.getElementById('terrifiltradoscamp').innerHTML="";
          if(resp.length<1){
            document.getElementById('terrifiltradoscamp').innerHTML="<div class='divterrifil'>No hay resultados</div>";
          }
          var idterri="";
          for(var i in resp){
            if(idterri!=resp[i].ID){
              document.getElementById('terrifiltradoscamp').innerHTML+=`<div class="divterrifil" onclick="ReqDatos.cambiarselectcam(${resp[i].ID},${resp[i].numero_territorio},'${resp[i].zona}')">Numero territorio: ${resp[i].numero_territorio} <span class="zo">zona:</span> ${resp[i].zona}</div>`;
            }
          idterri=resp[i].ID;
          }
      })
    })
  }
  cambiarselect(id,numero_territorio,zona){
    document.getElementById(id).selected=true;
    /**HAGO QUE SE DISPARE EL EVENTO CHANGE EN EL SELECT PARA PODER ESCUCHARLO EN LA FUNCION MOSTRARPREDICADO*/
    var evt = new Event('change');
    document.getElementById('showterriservicio').dispatchEvent(evt);
  }
  cambiarselectcam(id,numero_territorio,zona){
    document.getElementById(`camp${id}`).selected=true;
  }
  /**FUNCIO PARA FILTRAR PUBLICADOR QUE SE LLAMA DESDE PUBLICADORES.PHP**/
  filtrar_publicador(){
    if(document.getElementById('filterpubli').value==''){
      return document.getElementById('searchpubli').style.display="none";
    }
    var value = document.getElementById('filterpubli').value;
    var array = value.split(" ");
    const obj = {};
    if(array[0]){
      obj['nombre'] = array[0];
    }
    if(array[1]){
      obj['apellido'] = array[1];
    }
    if(array[2]){
      obj['apellido'] = array[1]+" "+array[2];
    }
    fetch(`${this.url}/Publicadores/buscar_publi`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(res=>{
      res.json().then(data=>{
        console.log(data)
        document.getElementById('searchpubli').innerHTML="";
        document.getElementById('searchpubli').style.display="block";
          if(data.length<1){
            document.getElementById('searchpubli').innerHTML="<div>No hay resultados</div>";
          }
         var datos    = data;
         var id       ='';    
         var number   = 0;
         var array    = [];
         var arraydiv = [];
        for(var key in datos){
          var f = new Date();
          var mes=f.getMonth()+1;
          /*Aqui agregamos un cero a la izquierda para poder comparar fechas**/
         mes=("0" + mes).slice(-2);
          var year=f.getFullYear();
          var day=f.getDate();
          var clasealerta='';
            if(!array.includes(datos[key].id)){
              document.getElementById('searchpubli').innerHTML+=`<div class="row linea" id="primerdiv${number}">
              <div class="col-md-4">${datos[key].nombre}</div>
              <div class="col-md-4 text-left">${datos[key].apellidos}</div>
              <div class="col-md-4"><a href="#modal_info_publicadores"><button type="button" onclick="ReqDatos.ver_publicador('${datos[key].id}');" class="btn btn-outline-info botonver"><i class="fas fa-eye"></i>Ver publicador</button></a></div>
             </div>`;
                 if(datos[key].id == datos[key].ID_publicador && datos[key].devuelta!=null){
                   if(year.toString()+"-"+mes.toString()+"-"+day.toString()>=datos[key].devuelta){
                    var indice = array.indexOf(datos[key].id);
                    document.getElementById(`primerdiv${number}`).classList.add("clasealer");
                    }
                  }
                if(datos[key].id == datos[key].ID_publicador_campaing && datos[key].devuelta_campaing!=null){
                   if(year.toString()+"-"+mes.toString()+"-"+day.toString()>=datos[key].devuelta_campaing){
                    var indice = array.indexOf(datos[key].id);
                    document.getElementById(`primerdiv${number}`).classList.add("clasealer");
                  }
                }
            }
            if(array.includes(datos[key].id) && datos[key].id == datos[key].ID_publicador && datos[key].devuelta!=null){
               if(year.toString()+"-"+mes.toString()+"-"+day.toString()>=datos[key].devuelta){
                var indice = array.indexOf(datos[key].id);
                document.getElementById(arraydiv[indice]).classList.add("clasealer");
              }
            }
            if(array.includes(datos[key].id) && datos[key].id == datos[key].ID_publicador_campaing && datos[key].devuelta_campaing!=null){
               if(year.toString()+"-"+mes.toString()+"-"+day.toString()>=datos[key].devuelta_campaing){
                var indice = array.indexOf(datos[key].id);
                document.getElementById(arraydiv[indice]).classList.add("clasealer");
              }
            }
          if(!array.includes(datos[key].id)){
            array[number] = datos[key].id;
            arraydiv[number] = `primerdiv${number}`;
          }
          id=datos[key].id;
          number++;
        }
      })
    })
  }
  notificar_publicador(data){
    console.log(data);
    /*fetch(`${this.url}/Publicadores/notificar_publicador`,{
      method:"POST",
      body:JSON.stringify(data),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(resp=>{
      resp.json().then(respuesta=>{
        console.log(respuesta);
      })
    })*/

  }
}
