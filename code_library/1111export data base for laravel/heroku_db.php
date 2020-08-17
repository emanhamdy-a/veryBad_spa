<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a  id='downloadLink' style='background-color:lightblue;display:block;user-select:none;text-align:center;cursor:pointer;padding:20px;border:1px solid darkgray;'>Save</a>
    <div id='sqlCode'style=''>
    <?php
        echo htmlentities("<");
        echo"?php<br>";
        // $tables = DB::select('SHOW TABLES');
        // $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'learn_code' ORDER BY CREATE_TIME desc");
        $tables=['users','password_resets','tracks','courses','videos','photoable','quizzes','questions','course_user','track_user','quiz_user'];
            // $table = get_object_vars( $table );
            foreach ($tables as $index => $tablnm) {
                $records = DB::table($tablnm)->get();
                if(count($records)>0){
                    echo "<br>//" . $tablnm ."<br>";
                    echoRecordes($records,$tablnm);
                }
            }
        function echoRecordes($records,$tablnm){
            echo"DB::table('" . $tablnm ."')->insert([<br>";
            $i=0;
            foreach ($records as $key => $value) {
                $i++;
                $d = get_object_vars( $value );
                echo "[";
                foreach ($d as $index => $data) {
                    echo "&quot" . $index . "&quot => &quot" . $data . "&quot,";
                }
                echo "],<br>";

                if(isset($d['id']) && count($records)==$i){
                    echo "]);<br>";
                    // echo"DB::statement(&quotALTER SEQUENCE $tablnm AUTO_INCREMENT = " . intval($d['id'] + 1) . ";&quot);";
                    echo"DB::statement(&quotALTER SEQUENCE " . $tablnm . "_id_seq RESTART WITH " . intval($d['id'] + 1) . "&quot);";
                }elseif (count($records)==$i) {
                    echo "]);<br>";
                }
            }
        }
        echo "unlink(__FILE__);<br>";
        echo"?>";
        // ALTER SEQUENCE product_id_seq RESTART WITH 1453
    ?>
    </div>
    <script>
        var sqlCode = document.getElementById('sqlCode').innerText;
        var anchor = document.querySelector('#downloadLink');
        anchor.onclick = function() {
            var sqlCode = document.getElementById('sqlCode').innerText.replace(/\[/g , '    [');
            // sqlCode=sqlCode.replace(/\[/g , '    [');
            anchor.href = 'data:text/plain;charset=UTF-8,' + encodeURIComponent(sqlCode);
            anchor.download = 'seeder.php';
        };
    </script>
</body>
</html>