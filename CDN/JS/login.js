
class login{
  constructor(url){
    this.cargando = false;
    this.url      = url;
  }
  /*funcion para destacar la agina donde estamos en el menu*/
  destacar_pagina(pagina){
    document.getElementById(pagina).style.color='#fff';
  }
  /*Con esta funcion cambiamos el elemento de html para ponerlo en forma de carga */
  function_Cargando(elemento){
     if(this.cargando){
        return elemento.innerHTML = "<span><i class='fa fa-spinner fa-spin' style='font-size:24px'></i></span>";
     }
        elemento.innerHTML = "";
  }
   mostrarpass(){
      if(document.getElementById('recipient-name').type == 'password'){
        document.getElementById('recipient-name').type  = 'text';
        document.getElementById('ver_pass').innerHTML   = 'Ocultar contraseña';
        return
      }
      
      document.getElementById('recipient-name').type  = 'password';
      document.getElementById('ver_pass').innerHTML   = 'Ver contraseña';
   }
  /*ANTES DE PROCEDER AL REGISTRO TENEMOS QUE VERIFICAR SI LA CLAVE SECRETA DE INVITACION ES CORRECTA*/
  secret_key(){
    let key = document.getElementsByName('clave')[0].value;
    if(key ===''){
      return
    }
    this.cargando = true;
    if(this.cargando){
      this.function_Cargando(document.getElementById('divcarga'));
    }
    fetch(`${this.url}/Login_register/comprobarKey`,{
      method:"POST",
      body:`key=${key}`,
      headers:{
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(response=>{
      response.json().then(texto => {
        this.cargando = false;
        this.function_Cargando(document.getElementById('divcarga'));
        if(texto){
         Swal.fire({
            type: 'success',
            title: 'Clave correcta',
            text: 'La clave es correcta',
          })
         return setTimeout(()=> window.location = `${this.url}/registrarse`, 2000);
        }
        Swal.fire({
            type: 'error',
            title: 'Clave incorrecta',
            text: 'La clave no es correcta',
        })

      });
    }).catch(error => {console.log(error)});
    document.getElementsByName('clave')[0].value='';
  }

  login_User(){
    let obj={usuario:document.getElementById('exampleInputEmail1').value,
             password:document.getElementById('exampleInputPassword1').value
            }
    this.cargando = true;
    if(this.cargando){
      this.function_Cargando(document.getElementById('divcargalogin'));
    }
    fetch(`${this.url}/Login_register/login`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( res => {
      res.json().then( data => {
        this.cargando = false;
        this.function_Cargando(document.getElementById('divcargalogin'));
        if(data === 'Necesitas activar tu cuenta, vaya a su correo electronico y compruebe el correo que le enviamos para activar su cuenta'){
          return Swal.fire({
            type: 'info',
            title: 'Necesitas activar tu cuenta',
            text: 'Necesitas activar tu cuenta, vaya a su correo electronico y compruebe el correo que le enviamos para activar su cuenta',
          });
        }
        if(data === false ){
          return Swal.fire({
            type: 'error',
            title: 'Error al ingresar su Usuario o email',
          });
        }
         Swal.fire({
            type: 'success',
            title: 'Acceso correcto',
            text: 'La clave es correcta',
          })
         return setTimeout(()=> window.location = `${this.url}/mi_perfil`, 2000);
      });
    });
  }

  register_User(){

    var forms = document.getElementsByClassName('needs-validation');
    let key = ["nombrecongregacion","provincia","localidad","nombreadministrador","apellidos","nombreusuario","email","password","passwordvalidatte"];
    let obj = {};
    let valido = true;
    for(var i=0; i< forms[0].length;i++){

      obj[key[i]] = document.getElementById(forms[0][i]['id']).value;
    }
    this.cargando = true;
    if(this.cargando){
      this.function_Cargando(document.getElementById('divcarga'));
    }
    fetch(`${this.url}/Login_register/registro`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(response=>{
      response.json().then(texto => {
        this.cargando = false;
        this.function_Cargando(document.getElementById('divcarga'));
        if(texto === 'El usuario o email ya existe por favor escoja otro'){
          return Swal.fire({
            type: 'error',
            title: 'Escoja otro email o usuario por favor',
            text: '',
          })
        }
        if(!texto){
          return
        }
         Swal.fire({
            type: 'success',
            title: 'Usuario creado correctamente',
            text: 'Hemos enviado un correo a su email para validar su cuenta, por favor vaya y valide su cuenta',
          }).then( ()=> window.location = `${this.url}/login`);
      });
    }).catch(error => {console.log(error)});
    
  }


  /***funcion para validar el formulario de registro
      Si el formulario es valido llamamos a la funcion registro para almacenar los datos
  **/
  Validar() { 
      var forms = document.getElementsByClassName('needs-validation');
      var boton = document.getElementById('botondatos');
      var validation = Array.prototype.filter.call(forms, function(form) {
        boton.addEventListener('click', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
          /*Comparo las dos contraseñas si no estan vacias y coinciden y todos los inputs estan rellenos
           llamamos a la funcion registrar para almacenar los datos*/
        }, false);
      });
      let pass1 = document.getElementById('validationCustom07').value;
      let pass2 = document.getElementById('validationCustom08').value;
      if( pass1!='' && pass2!='' && pass1 === pass2){
          this.register_User();
      }
  }

   /**
   Funcion para controlar el password del registro osea comparar que las contraseñas 
   **/
  controlPass(){
    let pass1 = document.getElementById('validationCustom07').value;
    let pass2 = document.getElementById('validationCustom08').value;
    if(pass1 == pass2 && pass1!='' &&pass2!=''){
      document.getElementsByClassName('passvalid')[0].style.display   = 'block';
      document.getElementsByClassName('passinvalid')[0].style.display = 'none';
      document.getElementById('validationCustom08').style.borderColor = '#28a745';
      return true;
    }
       document.getElementsByClassName('passinvalid')[0].style.display     = 'block';
       document.getElementsByClassName('passvalid')[0].style.display       = 'none';
       document.getElementById('validationCustom08').style.backgroundImage = 'none';
       document.getElementById('validationCustom08').style.borderColor     = '#dc3545';
       return false;
  }
    
}

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
      data.json().then(datos => document.getElementById('listdata').innerHTML=`<ul class="list-group listaperfil">
        <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Nombre:</div><div class="col-md-6 col-sm-6 col-6 datos" id="id_nombre">${datos.nombre}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_nombre" title="Actualizar datos" onclick="ReqDatos.update('${datos.nombre}','id_nombre')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_nombre" style="display:none">Actualizar</button></div></div></li>
        <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Apellidos:</div><div class="col-md-6 col-sm-6 col-6 datos" id="id_apellidos">${datos.apellidos}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_apellidos" title="Actualizar datos" onclick="ReqDatos.update('${datos.apellidos}','id_apellidos')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_apellidos" style="display:none">Actualizar</button></div></div></li>
        <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Email:</div><div class="col-md-6 col-sm-6 col-6 datosemail" id="id_email">${datos.email}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_email" title="Actualizar datos" onclick="ReqDatos.update('${datos.email}','id_email')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_email" style="display:none">Actualizar</button></div></div></li>
        <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Nombre Congregación:</div> <div class="col-md-6 col-6 col-sm-6 datos" id="id_nombre_congregacion">${datos.nombre_congregacion}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_nombre_congregacion" title="Actualizar datos" onclick="ReqDatos.update('${datos.nombre_congregacion}','id_nombre_congregacion')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_nombre_congregacion" style="display:none">Actualizar</button></div></div></li>
        <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Provincia:</div><div class="col-md-6 col-sm-6 col-6 datos" id="id_provincia">${datos.provincia}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_provincia" title="Actualizar datos" onclick="ReqDatos.update('${datos.provincia}','id_provincia')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_provincia" style="display:none">Actualizar</button></div></div></li>
        <li class="list-group-item"><div class="row"><div class="col-md-4 col-sm-4 col-4">Localidad:</div><div class="col-md-6 col-sm-6 col-6 datos" id="id_localidad">${datos.localidad}</div><div class="col-md-2 col-sm-2 col-2"><i class="fas fa-pen-nib" id="boton_id_localidad" title="Actualizar datos" onclick="ReqDatos.update('${datos.localidad}','id_localidad')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_id_localidad" style="display:none">Actualizar</button></div></div></li>
        </ul>`);
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
          <div class="col-md-3">Apellidos:</div>
          <div class="col-md-6 text-right"><i class="fas fa-circle"></i><span class="spancumplido">Publicadores con territorios cumplidos</span></div>
         </div>`;
         var datos      = data.publicadores;
         var pagination = data.total_paginas;
         var id='';
        for(var key in datos){
          var f = new Date();
          var mes=f.getMonth()+1;
          var year=f.getFullYear();
          var day=f.getDate();
          var clasealerta='';
          if(datos[key].devuelta!=null){
            if(year.toString()+mes.toString()+day.toString()>=datos[key].devuelta){
              document.getElementById('primerdiv').classList.add("clasealer");
            }
          }
          if(datos[key].devuelta_campaing!=null){
            if(year.toString()+mes.toString()+day.toString()>=datos[key].devuelta_campaing){
              document.getElementById('primerdiv').classList.add("clasealer");
            }
          }
          if(id!=datos[key].id){
            document.getElementById('listdatapubli').innerHTML+=`<div class="row linea" id="primerdiv">
            <div class="col-md-4">${datos[key].nombre}</div>
            <div class="col-md-4">${datos[key].apellidos}</div>
            <div class="col-md-4"><a href="#modal_info_publicadores"><button type="button" onclick="ReqDatos.ver_publicador('${datos[key].id}');" class="btn btn-outline-info botonver"><i class="fas fa-eye"></i>Ver publicador</button></a></div>
           </div>`;
          }
          id=datos[key].id;
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
}

class territorios{
   constructor(url,id,numpage){
    this.url      = url;
    this.id       = id;
    this.numpage  = numpage;
    this.cargando = false;
  }
  /*Con esta funcion cambiamos el elemento de html para ponerlo en forma de carga */
  function_Cargando(elemento){
     if(this.cargando){
        return elemento.innerHTML = "<span class='cargaterri'>Cargando...<i class='fa fa-spinner fa-spin' style='font-size:30px'></i></span>";
     }
        elemento.innerHTML = "";
  }
  activarFile(){
    document.getElementById('contefile').click();
  }
  add_Territorio(){
    document.getElementById('errorterritorios').innerHTML='';
    this.cargando=true;
      if(this.cargando){
        this.function_Cargando(document.getElementById('divcargaterritorios'));
      }
    let form  = document.getElementById('formpterritorios');
    if(document.getElementById('numero').value=='' || document.getElementById('zona').value==''){
       this.cargando=false;
       this.function_Cargando(document.getElementById('divcargaterritorios'));
       return document.getElementById('errorterritorios').innerHTML='El nombre y la zona del territorio son obligatorios';
    }
   const formData = new FormData();
    formData.append("objeto",document.getElementById('contefile').files[0]);
    formData.append('numero_terri',document.getElementById('numero').value);
    formData.append('zona',document.getElementById('zona').value);
    fetch(`${this.url}/territorios/add_territorio`,{
     method:"POST",
     body:formData
    }).then(resp => {
      resp.json().then(resj=>{
        console.log(resj);
        if(resj==='Este numero de territorio ya tiene esta zona asignada, cambia el numero o la zona por favor'){
          this.cargando=false;
          this.function_Cargando(document.getElementById('divcargaterritorios'));
          return document.getElementById('errorterritorios').innerHTML=resj;
        }
        if(resj){
          this.cargando=false;
          this.function_Cargando(document.getElementById('divcargaterritorios'));
          document.getElementById('cerrar-modal').click();
          return Swal.fire({
            type: 'success',
            title: 'Territorio creado correctamente',
            text: 'El territorio se ha creado correctamente',
          }).then(()=>{
            form.reset();
            document.getElementById('errorterritorios').innerHTML='';
            /*document.getElementById('listdatapubli').innerHTML   ='';
            document.getElementById('paginationpubli').innerHTML ='';*/
            //this.req_publicadores(this.numpage);
          });
        }
        if(!resj){
           document.getElementById('cerrar-modal').click();
            return Swal.fire({
            type: 'error',
            title: 'Ha habido un error al crear el territorio',
            text: '',
          }).then(()=>{
            form.reset();
          })
        }
      })
    })
  }

}



