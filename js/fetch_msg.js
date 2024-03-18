let chatCont = document.querySelector(".chat-msg");
let errovl = $(".chat-msg-ovl");
let incoming_id = $("#incoming_id_inp");
let chatInp = $("#send-msg-inp");
let subbtn = $("#send-btn");
let incoming_msg = $("#chat-msg");
let errorMessage = $("#error-message");

chatCont.onmouseenter = ()=>{
  chatCont.classList.add("active");
}

chatCont.onmouseleave = () => {
  chatCont.classList.remove("active");
};

let fetchmsgfunc = setInterval(() => {
  $.ajax({
    url: "logic/messages.php",
    method: "post",
    dataType: "text",
    data: {
      fetch_msg: "true",
      incoming_id: incoming_id.val(),
    },
    success: (data, stat) => {
      if (data == "Null") {
        errovl.show();
        errovl.css("display", "flex");
      } else if (data) {
        errovl.hide();
        errovl.css("display", "none");
        
        // Update chat content with encrypted messages
        chatCont.innerHTML = data;
        
        // Scroll to the bottom of the chat
        if (!chatCont.classList.contains("active")) {
          scrollmsg();
        }
      }
    }
  });
}, 500);


$(document).ready(function(){
  // Fonction pour envoyer un message
  $("#send-btn").click(function(e){
      e.preventDefault();

      // Récupérer la valeur sélectionnée pour la méthode de chiffrement
      var encryptionMethod = $("#encryptionMethod").val();
      var shiftValue = $("#shiftInput").val();
      var cesarShiftValue = $("#cesarShiftInput").val();
      var cesarDirection = $("#cesarDirectionInput").val();
      var affineInputA = $("#affineInputA").val();
      var affineInputB = $("#affineInputB").val();

      // Récupérer le message à envoyer
      var message = $("#send-msg-inp").val();

      // Récupérer l'ID de l'utilisateur destinataire
      var incoming_id = $("#incoming_id_inp").val();

      // Envoyer les données via AJAX
      $.ajax({
          url: 'logic/insert_msg.php',
          method: 'POST',
          data: {
              insert_data: true,
              user_inp: message,
              incoming_id: incoming_id,
              encryption_method: encryptionMethod,
              shift_value: shiftValue,
              cesar_shift_value: cesarShiftValue,
              cesar_direction: cesarDirection,
              affine_input_a: affineInputA,
              affine_input_b: affineInputB
          },
          success: function(response){
              // Réponse du serveur après insertion du message
              console.log(response);

              // Vérifiez si la réponse contient une erreur
              if (response.hasOwnProperty("error")) {
                  // Affichez le message d'erreur sous le bouton
                  errorMessage.text(response.error);
              } else {
                  // Affichez à la fois le message original et le message crypté
                  var originalMessage = response.original_message;
                  var encryptedMessage = response.encrypted_message;

                  // Affichez le message original et le message crypté dans l'interface du chat
                  // Par exemple, vous pouvez les afficher dans deux éléments séparés ou en les combinant dans un seul élément
                  // Exemple d'affichage dans deux éléments séparés
                  chatCont.innerHTML = "Message original : " + originalMessage + "<br>Message crypté : " + encryptedMessage;

                  // Scroll vers le bas pour afficher le nouveau message
                  scrollmsg();
              }
          },
          error: function(xhr, status, error){
              // En cas d'erreur lors de l'envoi AJAX
              console.error(xhr.responseText);
          }
      });
  });
});



function scrollmsg() {
  chatCont.scrollTop = chatCont.scrollHeight;
}