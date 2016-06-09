// inner variables
var canvas, context; // canvas and context objects
var imgBrick, imgSteel, imgWater, imgForest, imgTank; // images
var aMap; // map array
var oTank; // tank object

var iCellSize = 24; // cell wide
var iXCnt = 26; // amount of X cells
var iYCnt = 26; // amount of Y cells

// objects :
function Tank(x, y, w, h, image) {
    this.x = x;
    this.y = y;
    this.w = w;
    this.h = h;
    this.i = 0;
    this.image = image;
}

// functions
function clear() { // clear canvas function
    context.clearRect(0, 0, canvas.width, canvas.height);
}

function drawScene() { // main drawScene function
    clear(); // clear canvas

    // fill background
    context.fillStyle = '#111';
    context.fillRect(0, 0, canvas.width, canvas.height);

    // save current context
    context.save();

    // walk through our array
    for (var y = 0; y < iYCnt; y++) { 
        for (var x = 0; x < iXCnt; x++) {
            switch (aMap[y][x]) {
                case 0: // skip
                    break;
                case 1: // draw brick block
                    context.drawImage(imgBrick, 0, 0, iCellSize, iCellSize, x*iCellSize, y*iCellSize, iCellSize, iCellSize);
                    break;
                case 2: // draw steel block
                    context.drawImage(imgSteel, 0, 0, iCellSize, iCellSize, x*iCellSize, y*iCellSize, iCellSize, iCellSize);
                    break;
                case 3: // draw forest block
                    context.drawImage(imgForest, 0, 0, iCellSize, iCellSize, x*iCellSize, y*iCellSize, iCellSize, iCellSize);
                    break;
                case 4: // draw water block
                    context.drawImage(imgWater, 0, 0, iCellSize, iCellSize, x*iCellSize, y*iCellSize, iCellSize, iCellSize);
                    break;
            }
        }
    }

    // restore current context
    context.restore();

    // draw tank
    context.drawImage(oTank.image, oTank.i*oTank.w, 0, oTank.w, oTank.h, oTank.x, oTank.y, oTank.w, oTank.h);
}
// -------------------------------------------------------------

// initialization
$(function(){
    canvas = document.getElementById('scene');
    canvas.width  = iXCnt * iCellSize;
    canvas.height = iYCnt * iCellSize;
    context = canvas.getContext('2d');

    // main scene Map array
    aMap = ([
      [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0],
      [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0],
      [0, 0, 1, 1, 4, 4, 4, 4, 0, 0, 2, 2, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      [0, 0, 1, 1, 4, 4, 4, 4, 0, 0, 2, 2, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      [0, 0, 0, 0, 4, 4, 4, 4, 1, 1, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 0, 0, 2, 2, 0, 0],
      [0, 0, 0, 0, 4, 4, 4, 4, 1, 1, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 0, 0, 2, 2, 0, 0],
      [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 1, 1, 0, 0, 0, 0],
      [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 1, 1, 0, 0, 0, 0],
      [0, 0, 2, 2, 0, 0, 0, 0, 4, 4, 4, 4, 0, 0, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      [0, 0, 2, 2, 0, 0, 0, 0, 4, 4, 4, 4, 0, 0, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      [3, 3, 3, 3, 1, 1, 0, 0, 4, 4, 4, 4, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0],
      [3, 3, 3, 3, 1, 1, 0, 0, 4, 4, 4, 4, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0],
      [3, 3, 3, 3, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0, 0, 2, 2],
      [3, 3, 3, 3, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0, 0, 2, 2],
      [0, 0, 1, 1, 4, 4, 4, 4, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      [0, 0, 1, 1, 4, 4, 4, 4, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      [2, 2, 0, 0, 4, 4, 4, 4, 3, 3, 3, 3, 4, 4, 4, 4, 3, 3, 3, 3, 0, 0, 1, 1, 0, 0],
      [2, 2, 0, 0, 4, 4, 4, 4, 3, 3, 3, 3, 4, 4, 4, 4, 3, 3, 3, 3, 0, 0, 1, 1, 0, 0],
      [0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 0, 0, 4, 4, 4, 4, 3, 3, 3, 3, 4, 4, 4, 4, 0, 0],
      [0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 0, 0, 4, 4, 4, 4, 3, 3, 3, 3, 4, 4, 4, 4, 0, 0],
      [0, 0, 0, 0, 0, 0, 2, 2, 3, 3, 0, 0, 0, 0, 0, 0, 3, 3, 3, 3, 4, 4, 4, 4, 0, 0],
      [0, 0, 0, 0, 0, 0, 2, 2, 3, 3, 0, 0, 0, 0, 0, 0, 3, 3, 3, 3, 4, 4, 4, 4, 0, 0],
      [0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      [0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      [1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 2, 2, 0, 0, 0, 0],
      [1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 2, 2, 0, 0, 0, 0]
    ]);

    // load images
    imgBrick = new Image();
    imgBrick.src = 'images/brick.png';
    imgSteel = new Image();
    imgSteel.src = 'images/steel.png';
    imgWater = new Image();
    imgWater.src = 'images/water.png';
    imgForest = new Image();
    imgForest.src = 'images/forest.png';

    imgTank = new Image();
    imgTank.src = 'images/tank.png';
    oTank = new Tank(iCellSize*9, iCellSize*24, 48, 48, imgTank);

    $(window).keydown(function(event){ // keyboard alerts
        switch (event.keyCode) {
            case 38: // Up key
                oTank.i = 2;

                // checking collisions
                var iCurCelX = (2 * oTank.x) / 48;
                var iCurCelY = (2 * oTank.y) / 48;
                if (iCurCelY) {
                    var iTest1 = aMap[iCurCelY-1][iCurCelX];
                    var iTest2 = aMap[iCurCelY-1][iCurCelX+1];

                    if ((iTest1 == 0 || iTest1 == 3) && (iTest2 == 0 || iTest2 == 3)) {
                        oTank.y-=24;
                        if (oTank.y < 0) {
                            oTank.y = 0;
                        }
                    }
                }
                break;
            case 40: // Down key
                oTank.i = 3;

                // checking collisions
                var iCurCelX = (2 * oTank.x) / 48;
                var iCurCelY = (2 * oTank.y) / 48;
                if (iCurCelY+2 < iYCnt) {
                    var iTest1 = aMap[iCurCelY+2][iCurCelX];
                    var iTest2 = aMap[iCurCelY+2][iCurCelX+1];

                    if ((iTest1 == 0 || iTest1 == 3) && (iTest2 == 0 || iTest2 == 3)) {
                        oTank.y+=24;
                        if (oTank.y > 576) { //iCellSize * (iYCnt-2)
                            oTank.y = 576;
                        }
                    }
                }
                break;
            case 37: // Left key
                oTank.i = 1;

                // checking collisions
                var iCurCelX = (2 * oTank.x) / 48;
                var iCurCelY = (2 * oTank.y) / 48;
                var iTest1 = aMap[iCurCelY][iCurCelX-1];
                var iTest2 = aMap[iCurCelY+1][iCurCelX-1];

                if ((iTest1 == 0 || iTest1 == 3) && (iTest2 == 0 || iTest2 == 3)) {
                    oTank.x-=24;
                    if (oTank.x < 0) {
                        oTank.x = 0;
                    }
                }
                break;
            case 39: // Right key
                oTank.i = 0;

                // checking collisions
                var iCurCelX = (2 * oTank.x) / 48;
                var iCurCelY = (2 * oTank.y) / 48;
                var iTest1 = aMap[iCurCelY][iCurCelX+2];
                var iTest2 = aMap[iCurCelY+1][iCurCelX+2];

                if ((iTest1 == 0 || iTest1 == 3) && (iTest2 == 0 || iTest2 == 3)) {
                    oTank.x+=24;
                    if (oTank.x > 576) { //iCellSize * (iXCnt-2)
                        oTank.x = 576;
                    }
                }
                break;
        }
    });

    setInterval(drawScene, 40); // loop drawScene
});