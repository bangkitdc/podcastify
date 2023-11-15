const EPISODE_BASE_URL = "/episode/";

const getEpisode = (url) => {
  let xhr = new XMLHttpRequest();

  xhr.open("GET", EPISODE_BASE_URL + url, true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send();

  return xhr;
};

const addScript = (src) => {
  let existingScript = document.querySelector(`script[src="${src}"]`);
  if (existingScript) {
    existingScript.remove();
  }
  let script = document.createElement("script");
  script.src = src;
  document.body.appendChild(script);
};

// const showEpisode = (episodeId) => {
//   const url = "/episode/" + episodeId;
//   let xhr = getEpisode(url);

//   location.replace(url);

//   xhr.onload = () => {
//     document.getElementById("main-content").innerHTML = xhr.responseText;
//   };
// }

const showEditEpisode = (episodeId) => {
  const url = episodeId + "?edit=true";
  try {
    let xhr = getEpisode(url);
  
    xhr.onload = () => {
      if (xhr.status === 200) {
        document.getElementById("content-middle").innerHTML = xhr.responseText;
        addScript("/src/public/js/components/inputText.js");
        addScript("/src/public/js/components/modal.js");
        addScript("/src/public/js/episode/handle_upload_edit.js");
      } else {
        console.error("Request failed with status:", xhr.status);
      }
    };
  } catch (error) {
    console.error("An error occurred:", error);
  }
  
};

//COMMENT
let commentClicked = true;
const onClickComment = () => {
    if(commentClicked){
    const commentButtons = document.getElementById("comment-buttons");
    commentButtons.style.display = 'flex'
    commentClicked = false;
  }
}

if(document.getElementById('comment-cancel')){
  document.getElementById('comment-cancel').addEventListener("click", () => {
    const commentButtons = document.getElementById("comment-buttons");
    commentButtons.style.display = 'none';
    commentClicked = true;
  })
}

if(document.getElementById("comment-submit")){
  document.getElementById("comment-submit").addEventListener('click', async () => {
    const username = (await getSelf()).username;
    const episode_id = document.getElementById('episode_id').value;
    const text = document.getElementById('comment-input').value;

    const request = {
      episode_id : parseInt(episode_id),
      username: username,
      comment_text: text,
    }

    const xhr = new XMLHttpRequest();

    xhr.open("POST", "/membership/comment", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = () => {
      const response = JSON.parse(xhr.responseText);
      if (xhr.status === 200) {
        if (response.success) {
          showNotificationSuccess(response.message);

          setTimeout(() => {
            location.replace("/membership/prem_episode/" + episode_id);
          }, 1000);
        } else {
            showNotificationDanger(response.message);
        }
      } else {
        showNotificationDanger(response.message);
      }
    };

    xhr.send(JSON.stringify(request));
  })
}

//LIKE
let likeClicked = false;
if(document.getElementById("like-button-image")){
  document.getElementById("like-button-image").addEventListener("click", () => {
    const likeBtn = document.getElementById("like-button-image");
    const likeCtr = parseInt(document.getElementById("like-count").innerHTML);
    const likeText = document.getElementById("like-text").innerHTML;

    const fileName = likeBtn.src.split('/').pop();

    if(fileName === 'heart-fill.svg') {
      likeBtn.src = "/src/public/assets/icons/heart.svg";
      document.getElementById('like-count').innerHTML = likeCtr - 1;
      
      if (likeCtr - 1 === 1) {
        document.getElementById("like-text").innerHTML = "like";
      } else {
        document.getElementById("like-text").innerHTML = "likes";
      }
    } else {
      likeBtn.src = "/src/public/assets/icons/heart-fill.svg";
      document.getElementById('like-count').innerHTML = likeCtr + 1;

      if (likeCtr + 1 === 1) {
        document.getElementById("like-text").innerHTML = "like";
      } else {
        document.getElementById("like-text").innerHTML = "likes";
      }
    }

    const episode_id = document.getElementById('episode_id').value;

    const request = {
      episode_id : parseInt(episode_id),
    }

    const xhr = new XMLHttpRequest();

    xhr.open("POST", "/membership/like", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = () => {
      const response = JSON.parse(xhr.responseText);
      if (xhr.status === 200) {
        if (response.success) {
          showNotificationSuccess(response.message);
        } else {
          showNotificationDanger(response.message);
        }
      } else {
        showNotificationDanger(response.message);
      }
    };

    xhr.send(JSON.stringify(request));

  })
}