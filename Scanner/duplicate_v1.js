
function configure (){
    Webcam.set({
        width: 480,
        height: 360,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
}


//create Second Cam
function secondCamera_container(){
       //create second Camera Container
       let attach_camera = document.createElement('div')

       //assing id and class to the created div
       Object.assign(attach_camera,{
         id:"my_camera2", 
         className:"camera camera-2"
       })
   
       attach_camera.setAttribute('data-attach','camera 2')
       document.querySelector(".camera2-container").prepend(attach_camera)
}

let devices_arr = [];

navigator.mediaDevices.enumerateDevices()
  .then(function(devices) {
   
    devices.forEach(function(device) {
      if (device.kind === 'videoinput') {
        devices_arr.push(device)
      }     
    });

    console.log(devices_arr)

      var constraints1 = {
        deviceId: { exact: devices_arr[1].deviceId }//built-in Camera  deviceId
      };
      Webcam.set({ constraints: constraints1 });

      Webcam.attach('#my_camera');
      $('#my_camera video').attr('id','camera1')


      const saveSnap = () =>{        
        Webcam.snap(function(data_uri){
          document.getElementById('result_container').innerHTML =
          '<img id= "webcam" src = "'+ data_uri +'">';
        });

      var image_1 = document.querySelector("#result_container #webcam").src;
      Webcam.upload(image_1,'selfieCapture.php',function(code,text){
        alert('Save Successfully');

      });
     
      $('#snapShot_container').css('display','none');
      }
 
      // empty_img(image_1);

      return new Promise((resolve,reject)=>{  
        const snap_button = document.querySelector('#snapShot');
        if(!snap_button){
          return
        }
        //Capture using Button
        snap_button.addEventListener('click',()=>{
          resolve(saveSnap())
          
        })
      })

  }).then(()=>{

    secondCamera_container()

    var constraints2 = {
      deviceId: { exact: devices_arr[0].deviceId }//intergrated Camera deviceId
      };

      Webcam.set({ constraints: constraints2 });
      const second_camera = Webcam.attach('#my_camera2');
      $('#my_camera2 video').attr('id','camera2')

    function saveSnap2(){
          Webcam.snap(function(data_uri){
            document.getElementById('results_container_2').innerHTML =
            '<img id= "webcam" src = "'+ data_uri +'">';
             });
  
          var image_2 = document.querySelector("#results_container_2 #webcam").src;
          Webcam.upload(image_2,'selfieCapture.php',function(code,text){
            alert('Save Successfully');
          });
        }
      // empty_img(image_2);

      //Capture Using Interval
      const autoCapture = setInterval(() => {
        saveSnap2();
        reset_camera_container("#result_container")
        reset_camera_container("#results_container_2")
        reset_camera_container(".camera2-container")
        empty_img()
        alert('empty')
      }, 30000);

      setTimeout(() => {
        clearInterval(autoCapture)
      }, 34000);

  }).catch(function(err) {
    console.log(err.name + ": " + err.message);
  });


  function empty_img(){
    let cameras = document.querySelectorAll('#webcam');

    cameras.forEach(webcam => {
      webcam.setAttribute('src','')
    });
  }

  function offWebcam(cam){
    Webcam.reset(cam)
  }
  
  function reset_camera_container(container){
    document.querySelector(container).innerHTML = "";
  }