
class login{
  constructor(url){
    this.cargando = false;
    this.url      = url;
  }
  /*Con esta funcion cambiamos el elemento de html para ponerlo en forma de carga */
  function_Cargando(elemento){
     if(this.cargando){
        return elemento.innerHTML = "<span><i class='fa fa-spinner fa-spin' style='font-size:24px'></i></span>";
     }
        elemento.innerHTML = "";
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
         return setTimeout(()=> window.location = `${this.url}/Inicio_territorios/pagina_registro`, 2000);
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

  }

  register_User(){

    var forms = document.getElementsByClassName('needs-validation');
    let key = ["nombrecongregacion","provincia","localidad","nombreadministrador","apellidos","nombreusuario","email","password","passwordvalidatte"];
    let obj = {};
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
          }).then( ()=> window.location = `${this.url}/Inicio_territorios/Login`);
      });
    }).catch(error => {console.log(error)});
    
  }


  /***funcion para validar el formulario de registro
      Si el formulario es valido llamamos a la funcion registro para almacenar los datos
  **/
  Validar() {
    'use strict';
      
      var forms = document.getElementsByClassName('needs-validation');
      
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('click', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
          /*Comparo las dos contraseñas si no estan vacias y coinciden y todos los inputs estan rellenos
           llamamos a la funcion registrar para almacenar los datos*/

          let pass1 = document.getElementById('validationCustom07').value;
          let pass2 = document.getElementById('validationCustom08').value;
          if(form.checkValidity()!= false){
            if( pass1!='' && pass2!='' && pass1 === pass2){
            console.log('listo para almacenar datos');
            }

          }
        }, false);
      });
  };

   /**Funcion para controlar el password del registro osea comparar que las contraseñas **/
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



