
// jQuery fadeout
function fadeOutEffect(el, mode) {
    let fadeTarget = document.querySelector(el);
    let ms = mode === 'slow' ? 200 : 50;
    let fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity > 0) {
            fadeTarget.style.opacity -= 0.1;
        } else {
            clearInterval(fadeEffect);
            fadeTarget.parentNode.removeChild(fadeTarget);
        }
    }, ms);
}
