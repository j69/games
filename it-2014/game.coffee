board_size = 9

map = []

getRandomInt = (min, max) ->
  Math.floor(Math.random() * (max - min + 1)) + min

getDirShift = () ->
  shift_row = 0
  shift_col = 0
  dir = getRandomInt(0, 3)
  if dir == 1
    shift_row = 1
  else if dir == 2
    shift_row = -1
  else if dir == 3
    shift_col = 1
  else
    shift_col = -1

  {row: shift_row, col: shift_col}

blockRandomDir = (row, col) ->
  shift = getDirShift()
  unless map[row + shift.row][col + shift.col]
    map[row + shift.row][col + shift.col] = -1
    map[row + shift.row*2][col + shift.col*2] = -1

makeSourceMap = (size) ->
  last_index = size*3-1

  # init empty source array
  map = []
  for row in [0..last_index]
    row = []
    for col in [0..last_index]
      row.push 0
    map.push row

  # protect walls
  for idx in [0..last_index]
    map[0][idx] = -1
    map[last_index][idx] = -1
    map[idx][0] = -1
    map[idx][last_index] = -1

  # place server
  server = {
    row: getRandomInt(1, size-2)
    col: getRandomInt(1, size-2)
  }

  for shift_row in [-2..2]
    for shift_col in [-2..2]
      map[server.row*3+1+shift_row][server.col*3+1+shift_col] = -1

  map[server.row*3+1][server.col*3+1] = -2

  shift = getDirShift()

  map[server.row*3+1+shift.row][server.col*3+1+shift.col] = -2
  map[server.row*3+1+shift.row*2][server.col*3+1+shift.col*2] = 1

  # protect corners
  for row in [0..size-1]
    for col in [0..size-1]
      map[row*3][col*3] = -1
      map[row*3][col*3+2] = -1
      map[row*3+2][col*3] = -1
      map[row*3+2][col*3+2] = -1

  # wave!
  # TODO: ending condition
  for i in [1..60]
    for row in [0..last_index]
      for col in [0..last_index]
        if map[row][col] == i
          if i % 3 == 2
            # local center
            # block random directions
            free = 0
            for shift_row in [-1..1]
              for shift_col in [-1..1]
                unless map[row+shift_row][col+shift_col]
                  free++

            blockRandomDir(row, col)
          else
            for shift_row in [-1..1]
              for shift_col in [-1..1]
                if map[row+shift_row][col+shift_col] == i+1
                  map[row+shift_row][col+shift_col] = -1
          # TODO: block additional direction?

          # expand
          if map[row+1][col] == 0
            map[row+1][col] = i+1
          if map[row][col+1] == 0
            map[row][col+1] = i+1
          if map[row-1][col] == 0
            map[row-1][col] = i+1
          if map[row][col-1] == 0
            map[row][col-1] = i+1

    renderSourceMap map

  map

renderSourceMap = (map) ->
  $map = $('#map').empty()
  for row in map
    for cell in row
      $map.append $('<div>').text(cell).addClass("d-#{cell}")

$ ->
  renderSourceMap makeSourceMap(15)

