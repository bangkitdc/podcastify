const handleEpisode = (status, episode_id) => {
  if (status == 'Subscribed') {
    window.location.href='/membership/prem_episode/' + episode_id;
  } else {
    showNotificationDanger("You're not subscribed to the creator");
  }
}