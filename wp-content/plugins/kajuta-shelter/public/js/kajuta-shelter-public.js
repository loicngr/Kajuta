function getPosts() {
    fetch('/models.php?getPosts', {
        method: 'GET'
    }).then((response) => {
        const result = response.json();
        console.log(result);
    });
}

function main() {
    console.log('Kajuta Shelter - front office');
    // getPosts();
}
main();