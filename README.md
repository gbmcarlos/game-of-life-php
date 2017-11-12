# Game Of Life Coding Test (PHP version)
## Assignment
This test is designed to assess a candidate's general level of PHP/JS coding ability without reference to any particular framework. It is intended to be a test of style as well as ability. You will implement a cellular automaton as per the rules of Conway's Game of Life, that can be found at http://en.wikipedia.org/wiki/Conway%27s_Game_of_Life.
 
The program will be able to be deployed onto a web server as a set of PHP/JS scripts that will output animated preview to the calling browser. The program will be delivered as a .tar.gz archive. You may include a 3rd party framework if you wish (this might help with providing unit tests)
 
A user will visit an index.php that will give them the choice of having either a random initial condition of the game grid, or a Gosper Glider Gun (info on this can be found at the above URL).  The user will be delivered a web page that includes an animated grid preview that shows at least the first 100 iterations of life based on a 38 x 38 starting grid. If you want you might extend functionalities further in example adding ability to save in database or local storage information about designed pattern/grid etc.
 
You will use Object-Oriented programming style. Try not to implement procedural code dressed up as objects (although given the nature of this task there will be limits)
 
Provide unit tests for extra marks. 
 
You will be judged on your coding style, on the efficiency of your implementation and whether you provide unit tests.

## Requirements
* The game of life functionality will be implemented purely in PHP
* The application will be implemented using Silex as a PHP framework and Docker.

### User journey

#### Front page
* In the front page the user will see two buttons, "Random pattern", and "Gosper Glider Gun". 
* Each of the button will redirect the user to a different page. 

#### Random pattern page
* This page will show a functional grid of 38x38 started with a random pattern.
* The grid will show the 100 first iterations of the game

#### Gosper Glider Gun page
* This page will show a functional grid of 38x38 started with a Gosper Glider Gun.
* The grid will show the 100 first iterations of the game

### Tests
Tests are implemented with PHPUnit and can be run by executing `./deploy/tests.sh`.