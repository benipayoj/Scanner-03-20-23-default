
function configure (){
    Webcam.set({
        width: 480,
        height: 360,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  }
  
  
  //create Second Cam
  
  
  let devices_arr = [];
  
  navigator.mediaDevices.enumerateDevices()
  .then(function(devices) {
   
    devices.forEach(function(device) {
      if (device.kind === 'videoinput') {
        devices_arr.push(device)
      }
        
    });
  
    let scanner = devices_arr.splice((devices_arr.length - 1),1)[0];
    devices_arr.unshift(scanner)
    console.log(devices_arr)
  
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
  
      var constraints1 = {
        deviceId: { exact: devices_arr[0].deviceId }//built-in Camera  deviceId
      };
      Webcam.set({ constraints: constraints1 });
  
      Webcam.attach('#my_camera');
      $('#my_camera video').attr('id','camera1')
  
  
      //capture built-in Camera
      const saveSnap = () =>{ 
               
        Webcam.snap(function(data_uri){
          document.getElementById('result_container').innerHTML =
          '<img id= "webcam" src = "'+ data_uri +'">';
        });
  
      var image_1 = document.querySelector("#result_container #webcam").src;
      Webcam.upload(image_1,'selfieCapture.php',function(code,text){
        // image_1.setAttribute('src','')
        alert('Save Successfully');
  
      });
     
      $('#snapShot_container').css('display','none');
      }
      
      function attach_webcam_2(){
        var constraints2 = {
          deviceId: { exact: devices_arr[1].deviceId }//intergrated Camera deviceId
          };
  
          Webcam.set({ constraints: constraints2 });
          Webcam.attach('#my_camera2');
          $('#my_camera2 video').attr('id','camera2')
      }
  
      //capture Second Camera
      function saveSnap2(){
        Webcam.snap(function(data_uri){
          document.getElementById('results_container_2').innerHTML =
          '<img id= "webcam" src = "'+ data_uri +'">';
           });
  
        var image_2 = document.querySelector("#results_container_2 #webcam").src;
        Webcam.upload(image_2,'selfieCapture.php',function(code,text){
          // image_2.setAttribute('src','')
          alert('Save Successfully');
        });
      }
  
      
      // Remove Images
    
     const snapShot = () => new Promise((resolve,reject)=>{  
        const snap_button = document.querySelector('#snapShot');
  
        if(!snap_button){
          return
        }
        //Capture using Button
        snap_button.addEventListener('click',()=>{
          saveSnap();
  
          return new Promise((resolve,reject) =>{
            secondCamera_container();
            attach_webcam_2();
            const autoCapture = setInterval(() => {
              saveSnap2(); 
            }, 30000);
  
            setTimeout(() => {
              clearInterval(autoCapture)
            }, 34000);
          }).then(()=>{
  
            Webcam.reset('#results_container_2 #webcam')
            document.querySelector('.camera2-container').removeChild('video')
            reset_camera_container(".camera2-container")
            reset_camera_container("#my_camera2")
  
            async function remove_img(){
              let results = document.querySelectorAll('#result');
              results.forEach(result => {
                result.innerHTML = "";
              });
            }
          })
  
          })
        })
        return snapShot()
    //   }).catch(function(err) {
    // console.log(err.name + ": " + err.message);
  });
  
  
  function reset_camera_container(container){
    document.querySelector(container).innerHTML = "";
  }
  
  // Webcam.get((devices) => {
  //   const cameras = devices.filter(device => device.kind === 'videoinput');
  //   console.log('Webcam: '+ cameras);
  //   if (cameras.length !== numCameras) {
  //     // A new camera has been inserted
  //     console.log('New camera detected!');
  //     numCameras = cameras.length;
  //   }
  // });