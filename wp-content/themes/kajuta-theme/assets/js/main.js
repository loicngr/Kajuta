/**
 * Scroll la page de l'internaute vers la première Section du site
 */
function scrollToMain() {
    const currentPosition = scrollY || 0;
    window.scrollBy({
        top: (screen.height - currentPosition) - 95,
        left: 0,
        behavior: 'smooth'
    });
}

/**
 * Fonction principal
 */
function main() {
    /**
     *  Quand l'internaute clique sur le bouton "Découvrir" on appelle la fonction "scrollToMain"
     */
    document.getElementById("scrollToMain").addEventListener('click', scrollToMain);
}
window.onload = main;