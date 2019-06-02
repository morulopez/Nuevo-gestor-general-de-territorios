
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
        return elemento.innerHTML = "<span class='cargaterri'>Creando territorio...<i class='fa fa-spinner fa-spin' style='font-size:30px'></i></span>";
     }
        elemento.innerHTML = "";
  }
  activarFile(id,name,button=false){
    document.getElementById(id).click();
    document.getElementById(id).addEventListener('change',()=>{
          document.getElementById(name).innerHTML= document.getElementById(id).files[0].name;
          if(button){
            document.querySelector(".subirimg").style.display='inline-block';
            document.querySelector(".return").style.display='inline-block';
            document.querySelector(".return").addEventListener('click',()=>{
                document.querySelector(".subirimg").style.display='none';
                document.querySelector(".return").style.display='none';
                document.getElementById(name).innerHTML='';
                return;
            })
          }
        })
  }

  subirimg(idterri,actualizar=false){
    if(!actualizar){
          this.cargando=true;
            if(this.cargando){
              this.function_Cargando(document.getElementById('divcargaterritorios2'));
            }
          let formData = new FormData();
              formData.append('objeto',document.getElementById('contefileinfoterri').files[0]);
              formData.append('id_territorio',idterri);
          fetch(`${this.url}/territorios/add_img`,{
          method:"POST",
          body:formData
          }).then(resp=>{
            resp.json().then(respuesta=>{
              if(respuesta){
                this.cargando=false;
                this.function_Cargando(document.getElementById('divcargaterritorios2'));
                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000
                });
                Toast.fire({
                  type: 'success',
                  title: 'Imagen agregada correctamente'
                })
                return this.req_info_terri(idterri);
              }    
            })
          })
    }
    if(actualizar){
           this.cargando=true;
            if(this.cargando){
              this.function_Cargando(document.getElementById('divcargaterritorios2'));
            }
          let formData = new FormData();
              formData.append('objeto',document.getElementById('contefileinfoterri').files[0]);
              formData.append('id_territorio',idterri);
          fetch(`${this.url}/territorios/update_img`,{
          method:"POST",
          body:formData
          }).then(resp=>{
            resp.json().then(respuesta=>{
              if(respuesta){
                this.cargando=false;
                this.function_Cargando(document.getElementById('divcargaterritorios2'));
                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000
                });
                Toast.fire({
                  type: 'success',
                  title: 'Imagen actualizada correctamente'
                })
                this.req_info_terri(idterri);
              }    
            })
          })
    }
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
        if(resj==='Este numero de territorio ya tiene esta zona asignada, cambia el numero o la zona por favor'){
          this.cargando=false;
          this.function_Cargando(document.getElementById('divcargaterritorios'));
          document.getElementById('nombreimg').innerHTML='';
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
            document.getElementById('nombreimg').innerHTML='';
            document.getElementById('errorterritorios').innerHTML='';
            document.getElementById('listdatapubli').innerHTML   ='';
            document.getElementById('paginationpubli').innerHTML ='';
            this.req_territorios();
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
  req_territorios(){
    let obj = {"numpage": this.numpage};
    fetch(`${this.url}/territorios/req_all_territorios`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then( data => {
      data.json().then(data => {
         document.getElementById('listdatapubli').innerHTML+=`<div class="row firstline">
          <div class="col-md-3">Numero:</div>
          <div class="col-md-3 text-center">Zona:</div>
          <div class="col-md-6 text-right"><i class="fas fa-circle asignado"></i><span class="spancumplido">Asignado</span><i class="fab fa-cuttlefish asignadocampaña"></i><span class="spancumplido">Asignado en campaña</span></div>
         </div>`;
         var datos           = data.territorios;
         var pagination      = data.total_paginas;
         var asig_campaing   ='';
         var asig            ='';
        for(var key in datos){
    
          if(datos[key].asignado!=false){
            asig ='<i class="fas fa-circle asignado"></i>';
          }
          if(datos[key].asignado_campaing!=false){
            asig_campaing ='<i class="fab fa-cuttlefish asignadocampaña"></i>';
          }
            document.getElementById('listdatapubli').innerHTML+=`<div class="row linea" id="primerdiv">
            <div class="col-md-4">${datos[key].numero_territorio}</div>
            <div class="col-md-4">${datos[key].zona} ${asig}${asig_campaing}</div>
            <div class="col-md-4"><a href="#modal_info_territorios"><button type="button" onclick="ReqDatosTerri.req_info_terri('${datos[key].id}');" class="btn btn-outline-info botonver"><i class="fas fa-eye"></i>Ver territorio</button></a></div>
           </div>`;
           asig_campaing   ='';
           asig            ='';
        }
        for(var i=1;i<=pagination;i++){
            document.getElementById('paginationpubli').innerHTML+=`<a class="page-link" href="${this.url}/territorios/${i}">${i}</a>`
        }
      });
    });
  }
  req_info_terri(id){
    console.log(id);
    let obj={"id":id};
    fetch(`${this.url}/Territorios/info_territorio`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded' 
      }}).then( res => {
          res.json().then( respuesta => {
            document.getElementById('show_info_territorios').innerHTML= respuesta
          })
      })
  }
  /***Esta funcion sirve para actualizar los datos del territorio, numero y zona.Tam bien la imagen del territorio
  sea que el territorio tenga imagen y se quiera cambiar o sea que el territorio no tenga y se quiera subir**/
  actualizar_terri(id,img=false){
    if(!img){
      document.getElementById('iconoactualizar').style.display='none';
      document.getElementById('botonactualizar').style.display='inline-block';
      var numero = document.getElementById('numeroterri').innerHTML;
      var zona   = document.getElementById('spanzona').innerHTML;
      document.getElementById('numeroterri').innerHTML=`<input class="form-control" value="${numero}" id="imputnumero">` 
      document.getElementById('spanzona').innerHTML=`<input class="form-control" value="${zona}" id="imputzona">`
      document.getElementById('botonactualizar').addEventListener('click',()=>{
        if(document.getElementById('imputnumero').value === numero && document.getElementById('imputzona').value === zona){
            document.getElementById('iconoactualizar').style.display='inline-block';
            document.getElementById('botonactualizar').style.display='none';
           document.getElementById('numeroterri').innerHTML = numero;
           document.getElementById('spanzona').innerHTML    = zona;
            return;
        }
         const obj = {
          "id":id,
          "numero_terri":document.getElementById('imputnumero').value,
          "zona":document.getElementById('imputzona').value
         }
        fetch(`${this.url}/Territorios/actualizar_territorio`,{
          method:"POST",
          body:JSON.stringify(obj),
          headers:{
            'Accept':'application/JSON',
            'Content-Type':'application/x-www-form-urlencoded'
          }
        }).then(resps=>{
          resps.json().then(resp=>{
            if(resp ==='No puede haber ningun campo vacio' || resp === 'El numero de territorio y zona ya existe'){
              document.getElementById('spanerror2').style.display='block';
              document.getElementById('spanerror2').innerHTML=resp;
              return setInterval(()=>{ document.getElementById('spanerror2').style.display='none'; }, 6000);
            }
            if(resp){
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
              this.req_info_terri(id);
              document.getElementById('listdatapubli').innerHTML='';
              document.getElementById('paginationpubli').innerHTML='';
              this.req_territorios();
            }
          })
        })
      })
    }
  }
  borrarObservacion(id_terri,id){
    fetch(`${this.url}/Territorios/borrarObservacion`,{
      method:"POST",
      body:`id=${id}`,
      headers:{
        'Content-Type':'application/x-www-form-urlencoded'
      }
    }).then(res =>{
      res.json().then( respuesta =>{
        console.log(respuesta);
        if(respuesta){
           const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'Observacion borrada correctamente'
          })
          this.req_info_terri(id_terri);
        }
      });
    })
  }
  borrarObservacionhistorial(id_terri,id){
    fetch(`${this.url}/Territorios/borrarObservacionhistorial`,{
      method:"POST",
      body:`id=${id}`,
      headers:{
        'Content-Type':'application/x-www-form-urlencoded'
      }
    }).then(res =>{
      res.json().then( respuesta =>{
        console.log(respuesta);
        if(respuesta){
           const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'Observacion de historial borrada correctamente'
          })
          this.req_info_terri(id_terri);
        }
      });
    })
  }
  mostrar(mostrar){
    document.getElementById(mostrar).style.display='block';
  }
  cerrarventana(cerrar){
    document.getElementById(cerrar).style.display='none';
  }
  crearobservacion(id_terri){
    let observacion=document.getElementById('infoobservacion').value;
    if(observacion===''){
      return;
    }
    let fecha = this.obtenerfecha();
    let obj={
      "fecha":fecha,
      "obser":observacion,
      "id_territorio":id_terri
    };
    fetch(`${this.url}/territorios/createobservacion`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded' 
      }
    }).then(res=>{
      res.json().then(respuesta=>{
        console.log(respuesta);
        if(respuesta){
           const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            type: 'success',
            title: 'Observacion creada con exito'
          })
          this.req_info_terri(id_terri);
        }
      })
    })
  }
  obtenerfecha(){
    var d = new Date();
    var year  = d.getFullYear();
    var month = d.getMonth()+1;
     month=("0" + month).slice(-2);
    var day   = d.getDate();
    return year.toString()+'-'+month.toString()+'-'+day.toString();
  }
  borrarterritorio(id,asig,asigcampaing){
    if(asig || asigcampaing){
       return Swal.fire({
              type: 'info',
              title: 'No puedes borrar este territorio',
              text: 'El territorio está asignado y debes devolverlo antes de poder borrarlo',
            });
    }else{
      Swal.fire({
        title:`¿Está seguro de eliminar este territorio?`,
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
            console.log('borrado');
            fetch(`${this.url}/Territorios/eliminar_terri`,{
                method:"POST",
                body:`id=${id}`,
                headers:{
                  'Content-Type':'application/x-www-form-urlencoded' 
                }
            }).then(res=>{
              res.json().then(resp =>{
                if(resp){
                const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });
                Toast.fire({
                  type: 'success',
                  title: 'Territorio borrado'
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
  /**ESTA FUNCION SE LLAMA DESDE TERRITORIOS.PHP Y CON ELLA FILTRMOS LOS TERRITORIOS SEGUN NUMERO Y ZONA**/
  filtrar_territorio(){
    if(document.getElementById('filterterri').value==''){
      return document.getElementById('searchterri').style.display="none";
    }
    var value = document.getElementById('filterterri').value;
    var array = value.split(" ");
    const obj = {};
    if(array[0]){
      obj['numero'] = array[1];
    }
    if(array[0]){
      obj['zona'] = array[0];
    }
     if(array[2]){
      obj['zona'] = array[1]+" "+array[2];
    }
    fetch(`${this.url}/Territorios/filtrar_terri`,{
      method:"POST",
      body:JSON.stringify(obj),
      headers:{
        'Accept':'application/JSON',
        'Content-Type':'application/x-www-form-urlencoded'  
      }
    }).then(res=>{
      res.json().then(data=>{
        document.getElementById('searchterri').innerHTML="";
        document.getElementById('searchterri').style.display="block";
        var asig_campaing   ='';
        var asig            ='';
        for(var key in data){
          
          if(data[key].asignado!=false){
            asig ='<i class="fas fa-circle asignado"></i>';
          }
          if(data[key].asignado_campaing!=false){
            asig_campaing ='<i class="fab fa-cuttlefish asignadocampaña"></i>';
          }
            document.getElementById('searchterri').innerHTML+=`<div class="row linea" id="primerdiv">
            <div class="col-md-4">${data[key].numero_territorio}</div>
            <div class="col-md-4">${data[key].zona} ${asig}${asig_campaing}</div>
            <div class="col-md-4"><a href="#modal_info_territorios"><button type="button" onclick="ReqDatosTerri.req_info_terri('${data[key].id}');" class="btn btn-outline-info botonver"><i class="fas fa-eye"></i>Ver territorio</button></a></div>
           </div>`;
           asig_campaing   ='';
           asig            ='';
        }
      })
    })
  }
}
