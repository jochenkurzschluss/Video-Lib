const videoPlayer = document.getElementById('videoPlayer');
const playlist = document.getElementById('playlist');
const listItems = playlist.querySelectorAll('li');
let currentVideoIndex = 0;
function loadVideo(index) {
    if (index >= 0 && index < videoPaths.length) {
        currentVideoIndex = index;
        const newSrc = videoPaths[index];
        videoPlayer.src = newSrc;
        videoPlayer.load();
        videoPlayer.play();
        updatePlaylistHighlight(index);
    }
}
function updatePlaylistHighlight(index) {
    listItems.forEach(item => {
        item.classList.remove('current-video');
    });
    if (listItems[index]) {
        listItems[index].classList.add('current-video');
    }
}
listItems.forEach(item => {
    item.addEventListener('click', function() {
        const index = parseInt(this.getAttribute('data-index'));
        loadVideo(index);
    });
});
videoPlayer.addEventListener('ended', function() {
    let nextIndex = currentVideoIndex + 1;
    if (nextIndex >= videoPaths.length) {
        nextIndex = 0; 
    }
    loadVideo(nextIndex);
});
if (videoPaths.length > 0) {
    loadVideo(0);
}