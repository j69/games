<html>
	<head>
		<script src="http://code.jquery.com/jquery-1.8.2.min.js">//91.2 KB</script>
		<style type="text/css">
			canvas{
				margin: 0 auto;
				display: block;
				border: 2px double black;
			}
		</style>
		<script>
			$(function(){
				//Canvas
				var ctx = $('canvas')[0].getContext('2d');// Контекст холста
				var w = $("#canvas").width();
				var h = $("#canvas").height();

				var cw = 10;//width of cell
				var d;
				var food;
				var score;
				var snake_array;

				start();

				//controlz
				$(document).keydown(function(e){
					var key = e.which;
					if		(key == "37" && d != "right")	d = "left";
					else if (key == "38" && d != "down")	d = "up";
					else if (key == "39" && d != "left")	d = "right";
					else if (key == "40" && d != "up")		d = "down";
				})

////////////////////////////////////////////////////////////////////////////////////////////

				function start(){
					d = "right";
					create_snake();
					create_food();
					score = 0;
					// timer fo 60ms
					if(typeof game_loop != "undefined") clearInterval(game_loop);
					game_loop = setInterval(paint, 60);
				}

				function create_snake(){
					var length = 4; //Длинна змеи
					snake_array = []; //Пустой массив для старта
					for(var i = length-1; i>=0; i--){
						snake_array.push({x: i, y:20});//horizontal
					}
				}

				function create_food(){
					food = {
						x: Math.round(Math.random()*(w-cw)/cw),
						y: Math.round(Math.random()*(h-cw)/cw),
					};
				}

				function paint(){
					//Draw background
					ctx.fillStyle = "white";
					ctx.fillRect(0, 0, w, h);
					ctx.strokeStyle = "black";
					ctx.strokeRect(0, 0, w, h);

					//snake contorl
					var nx = snake_array[0].x;
					var ny = snake_array[0].y;
					if(d == "right") nx++;
					else if(d == "left") nx--;
					else if(d == "up") ny--;
					else if(d == "down") ny++;

					//restart if end of field
					if(nx == -1 || nx == w/cw || ny == -1 || ny == h/cw || check_collision(nx, ny, snake_array)){
						start();
						return;
					}
					//snake eat food
					if(nx == food.x && ny == food.y){
						var tail = {x: nx, y: ny};
						score++;
						create_food();
					} else {
						var tail = snake_array.pop(); //pops out the last cell
						tail.x = nx; tail.y = ny;
					}
					snake_array.unshift(tail);
					//paint snake and food
					for(var i = 0; i < snake_array.length; i++){
						var c = snake_array[i];
						paint_cell(c.x, c.y);
					}
					paint_cell(food.x, food.y);
					//show score
					var score_text = "Score: " + score;
					ctx.fillText(score_text, 5, h-5);
				}

				function paint_cell(x, y){
					ctx.fillStyle = "#cd00cd";
					ctx.fillRect(x*cw, y*cw, cw, cw);
					ctx.strokeStyle = "white";
					ctx.strokeRect(x*cw, y*cw, cw, cw);
				}

				function check_collision(x, y, array){
					for(var i = 0; i < array.length; i++)
					{
						if(array[i].x == x && array[i].y == y)
						 return true;
					}
					return false;
				}
			});
		</script>
	</head>
	<body>
		<canvas height='320' width='240' id='canvas'>Refresh browser</canvas>
	</body>
</html>