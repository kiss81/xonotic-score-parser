# xonotic-score-parser
simple php script that takes a local score file and shows it on a web page.

add this to your server.cfg

sv_logscores_file 1
sv_logscores_filename "score.txt"
//sv_logscores_bots 1 (optional if you want bots in your logging)

put the parse.php on the same server as your xonotic game. 
I made a symbolic link (ln -s) to the score.txt file (/home/user/.xonotic/data/data/score.txt to the same directory as parse.php
Fix the paths and title to your own liking and add some css to make it look nice if you want to. 
I use nginx with php-fpm

// todo:
- make it configurable
- add some css to make it look better :)
