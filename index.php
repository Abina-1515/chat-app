<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.13.2/firebase-app.js"></script>

<script src="https://www.gstatic.com/firebasejs/7.13.2/firebase-database.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.13.2/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyDXmfrtZmJ1kE_zS6dVc0Q1vEy2445ksuQ",
    authDomain: "chatapp-44ee4.firebaseapp.com",
    databaseURL: "https://chatapp-44ee4.firebaseio.com",
    projectId: "chatapp-44ee4",
    storageBucket: "chatapp-44ee4.appspot.com",
    messagingSenderId: "286313760176",
    appId: "1:286313760176:web:977755ecd12dca22db8275",
    measurementId: "G-J30LJD3F2Z"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();


  var myName = prompt("Enter your name");

  function sendMessage()
  {
    var message=document.getElementById("messaage").value;

    firebase.database().ref("messages").push().set({
      "sender":myName,
      "message":message

    });
    return false;
  }
  firebase.database().ref("messages").on("child_added",function(snapshot){
    var html = "";
    html += "<li id='message-" + snapshot.key +"'>";

    if (snapshot.val().sender == myName) {
      html += "<button data-id= '" + snapshot.key +"' onclick='deleteMessage(this);'>";
      html += "Delete";

      html += "</button>"
    }
    html += snapshot.val().sender + ": " + snapshot.val().message;

    html += "</li>";

    document.getElementById("messages").innerHTML += html;

  });

  function deleteMessage(self){
    var messageId=self.getAttribute("data-id");

    firebase.database().ref("messages").child(messageId).remove();
  }

  firebase.database().ref("messages").on("child_removed", function(snapshot){
    document.getElementById("message-" + snapshot.key).innerHTML="This message has been removed";
  });

</script>

<form onSubmit="return sendMessage();">
  <input id="messaage" placeholder="Enter message" autocomplete="off">

  <input type="submit">
  
</form>

<ul id="messages"></ul>