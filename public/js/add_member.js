
let globalProjectColor = document.querySelector(".title-line");

globalProjectColor.style.backgroundColor = "#" + colorToHex(globalProjectColor.getAttribute('data-color'));

function colorToHex(color) {
    let colors = {
        'Orange' : 'f77d13',
        'Yellow' : 'ffcc00',
        'Red' : 'e82020',
        'Green' : '2dcc71',
        'Lilac' : '9c58b6',
        'Sky' : '4894dd',
        'Brown' : 'c45e00',
        'Golden' : 'f39c13',
        'Bordeaux' : 'c92b1a',
        'Emerald' : '179f85',
        'Purple' : '7f14ad',
        'Blue' : '2880ba',
    };

    return colors[color];
}