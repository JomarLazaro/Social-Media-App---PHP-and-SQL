/*===== SHOW NAVBAR  =====*/ 
const showNavbar = (toggleId, navId, bodyId, headerId) =>{
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId),
    bodypd = document.getElementById(bodyId),
    headerpd = document.getElementById(headerId)

    // Validate that all variables exist
    if(toggle && nav && bodypd && headerpd){
        toggle.addEventListener('click', ()=>{
            // show navbar
            nav.classList.toggle('show')
            // change icon
            toggle.classList.toggle('bx-x')
            // add padding to body
            bodypd.classList.toggle('body-pd')
            // add padding to header
            headerpd.classList.toggle('body-pd')
        })
    }
}

showNavbar('header-toggle','nav-bar','body-pd','header')

/*===== LINK ACTIVE  =====*/ 
const linkColor = document.querySelectorAll('.nav__link')

function colorLink(){
    if(linkColor){
        linkColor.forEach(l=> l.classList.remove('active'))
        this.classList.add('active')
    }
}
linkColor.forEach(l=> l.addEventListener('click', colorLink))

//notification
document.addEventListener('DOMContentLoaded', function () {
    const notificationLink = document.getElementById('notification-link');
    const notificationDropdown = document.getElementById('notification-dropdown');

    notificationLink.addEventListener('click', function (event) {
      event.preventDefault();
      notificationDropdown.classList.toggle('show');
    });

    // Close dropdown if the user clicks outside of it
    window.addEventListener('click', function (event) {
      const notificationDropdown = document.getElementById('notificationDropdown');
      if (event.target !== notificationDropdown && !notificationDropdown.contains(event.target)) {
          notificationDropdown.classList.remove('show');
      }
  });
  });

  // Upload File
  function uploadFile() {
    const fileInput = document.getElementById('fileInput');
    const fileDetails = document.getElementById('fileDetails');

    const file = fileInput.files[0];

    if (file) {
        fileDetails.textContent = `File Name: ${file.name}, Type: ${file.type}, Size: ${file.size} bytes`;
    } else {
        fileDetails.textContent = 'No file selected.';
    }
}
document.addEventListener('DOMContentLoaded', function () {
    // Add click event listener to like buttons
    document.querySelectorAll('.like-button').forEach(function (button) {
        button.addEventListener('click', function () {
            toggleLike(this);
        });
    });

    // Function to handle the like action
    function toggleLike(button) {
        var postId = button.getAttribute('data-post-id');
        var isLiked = button.getAttribute('data-is-liked');

        // Send an AJAX request to handle the like action
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'controller.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Parse the JSON response
                var response = JSON.parse(xhr.responseText);

                // Update the like count and icon based on the response
                var likeCountElement = button.querySelector('.like-count');
                var likeIcon = button.querySelector('i');

                if (response.success) {
                    if (response.isLiked) {
                        isLiked = true;
                        likeCountElement.textContent = parseInt(likeCountElement.textContent) + 1;
                        likeIcon.classList.add('bxs-like');
                        likeIcon.classList.remove('bx-like');
                    } else {
                        isLiked = false;
                        likeCountElement.textContent = parseInt(likeCountElement.textContent) - 1;
                        likeIcon.classList.remove('bxs-like');
                        likeIcon.classList.add('bx-like');
                    }
                    // Update the data-is-liked attribute for future reference
                    button.setAttribute('data-is-liked', isLiked ? '1' : '0');
                } else {
                    console.error('Error updating like status.');
                }
            }
        };

        // Send the POST data
        xhr.send('likePost=true&postId=' + postId);
    }
});

