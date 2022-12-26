<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//if the file is uploaded with any errors encounterd
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
    //setting the allowed file format
    $allowed = array("pdf" => "application/pdf");
    //getting the files name,size and type using the $_FILES //superglobal
    $filename = $_FILES['pdf']['name'];
    $filesize = $_FILES['pdf']['size'];
    $filetype = $_FILES['pdf']['type'];
    //verifying the extention of the file
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!array_key_exists($ext, $allowed)) die("Error: the file format is not acceptable");
    //verifying the file size
    $maxsize = 5 * 1024 * 1024;
    if ($filesize > $maxsize) die("Error: file size too large!!");
    if (in_array($filetype, $allowed)) {
        if (file_exists("temp/" . $filename)) {
            die("Sorry the file already exists");
        } else {
            move_uploaded_file($_FILES['pdf']['tmp_name'], "temp/" . $filename);
            echo "File was uploaded successfully <br>";
        }
    } else {
        echo "Sorry a problem was encountered when trying to upload data!!";
    }
} else {
    echo "Error: " . $_FILES['pdf']['error'];
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mergi.fy</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins&family=Ubuntu&display=swap" rel="stylesheet">
<style>
    html {
        font-family: 'Poppins';
        background: url("/rect.svg");
        background-size: cover;
        background-repeat: no-repeat;
    }

    .disabled {
        pointer-events: none;
        color: #aaaaaa8f !important;
    }

    .nav {

        left: 144px;
        top: 39px;
        display: flex;
        padding: 25px;
        position: absolute;
        flex-direction: row;
        align-items: center;
        gap: 535px;
        justify-items: center;
    }

    .navico {
        margin: 0;
        font-size: 2.2em;
        color: white;
    }

    .opts {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        padding: 0px;
        right: 143px;
        top: 53.5px;
        flex-direction: row;
        display: flex;
        gap: 20px;
    }

    .optin {
        font-size: 1.2em;
        color: white;
        width: max-content;
        text-decoration: none;
    }

    .upbox {
        box-sizing: border-box;
        justify-content: center;
        align-content: center;
        margin: auto;
        width: 50%;
        display: flex;
        padding-top: 10%;
        flex-wrap: wrap;
        position: absolute;
        height: 457px;
        left: calc(50% - 760px/2);
        top: 252px;

        background: rgba(37, 0, 37, 0.06);
        mix-blend-mode: normal;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(160px);
        /* Note: backdrop-filter has minimal browser support */

        border-radius: 0px 0px 10px 10px;
    }

    .uptext {
        position: absolute;
        width: max-content;
        font-family: 'Ubuntu';
        font-style: normal;
        font-weight: 700;
        font-size: 48px;
        line-height: 55px;

        color: #FFFFFF;
    }

    .pre2 {
        font-size: 12px;
        position: relative;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .txt {
        font-family: 'Ubuntu';
        font-style: normal;
        font-weight: 700;
        font-size: 48px;
        color: #FC33FF;
    }

    .but {
        font-family: 'Ubuntu';
        height: fit-content;
        font-style: normal;
        font-weight: 700;
        font-size: 30px;
        margin-top: 50px;
        padding: 20px;
        color: #FC33FF;
        box-sizing: border-box;
        border: none;
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(123.5px);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.25);
        /* Note: backdrop-filter has minimal browser support */

        border-radius: 40px;
        transition-duration: .2s;
    }

    .prev {
        position: absolute;
    }

    .but:hover {
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        background: #FC33FF;
        color: white;

    }

    #upload {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }

    td {
        font-family: 'Ubuntu';
        height: fit-content;
        font-style: normal;
        font-weight: 700;
        font-size: 1em;
        padding: 5px;
        color: #FFFFFF;
    }

    .tab {
        padding: 20px;
        border: #FC33FF;
    }

    .step2 {
        top: 1000px;
        display: flex;
        flex-wrap: wrap;
        width: -webkit-fill-available;
        justify-content: center;
        align-content: center;
        padding: 40px;
        position: absolute;
    }

    .step2_div {
        width: 466px;
        height: 421px;
        background: rgba(255, 255, 255, 0.04);
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(123.5px);
        display: flex;
        align-items: center;
    }

    .wrapper {
        position: aboslute;
        font-family: 'Ubuntu';
        height: fit-content;
        font-style: normal;
        font-weight: 700;
        font-size: 1em;
        padding: 5px;
        color: #FFFFFF;

    }

    .text {
        cursor: row-resize;
    }

    .item {
        padding: 20px;

    }

    .small {
        padding: 10px !important;
        font-size: 10px !important;
        border-radius: 5px !important;
        margin: auto !important
    }

    .fa {
        cursor: pointer;
    }
</style>
<script>
    var count = 0;
    const dt = new DataTransfer()
    function selected(up) {
        let files = up.files;
        if (files.length != 0) {
            document.getElementById('uptext').hidden = true;
            var divhold = document.getElementById('tab')
            document.getElementById('prev').hidden = false;
            document.getElementById('next').disabled = false;
            $("#next").removeClass("disabled");


        }

        for (file of files) {
            console.log(file)
            if (count <= 3) {
                divhold.innerHTML += `
                    <td>${file.name}</td>
                    `
            } else {
                document.getElementById('lab').innerHTML = "Maximum 4 files"
                document.getElementById('lab').classList = "but disabled "
                removeFile(count);
            }
            count++
        }
    }

    function removeFile(name) {
        var files = document.getElementById('upload').files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i]
            if (name !== file.name)
                dt.items.add(file) // here you exclude the file. thus removing it.
        }

        files = dt.files // Assign the updates list
    }

    function step2() {
        document.getElementById("step2").scrollIntoView({
            behavior: 'smooth'
        });
        var files = document.getElementById('upload').files;
        ls = document.getElementById('list');

        for (let i = 0; i < files.length; i++) {

            ls.innerHTML += `
                <div class="item">
                <span class="text">${files[i].name}</span>
                <i style="font-size:14px" class="fa" onclick="removeFile('${files[i].name}')">&#xf057;</i>
                </div>  
                </div>
                `
        }
    }

    function chn() {
        let divs = (document.querySelectorAll(".text"));
        for (let index = 0; index < divs.length; index++) {
            console.log(divs[index].id)
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.2/Sortable.min.js">

</script>
<script src="index.js"></script>
</head>

<body>
<div class="nav">
    <p class="navico">Mergi.fy</p>
    <div class="opts">
        <a href="" class="optin">Merge PDF</a>
        <a href="" class="optin disabled">Comming Soon</a>
        <a href="" class="optin disabled">Comming Soon</a>
        <a disabled href="" class="optin disabled">Comming Soon</a>
    </div>
</div>
<div class="upbox">
    <div class="prev" id="prev" hidden>
        <div class="uptext pre2">YOU CAN EDIT YOUR PDF(s) LATER</div>
        <table class="tab">
            <tbody>
                <tr id="tab">

                </tr>
            </tbody>
        </table>
    </div>
    <div class="uptext" id='uptext'>UPLOAD AND&nbsp;<span class="txt">MERGE</span></div>
    <label class="but" id="lab" for="upload">SELECT FILES</label>
    <input type="file" class='but' onchange="selected(this)" id="upload" multiple accept="application/pdf"></input>&nbsp;
    <input type="Button" class='but disabled' id="next" onclick="step2()" value="Next Step" disabled></input>
</div>



<section id='step2' class="step2">
    <div class="step2_div">
        <div class="wrapper" id="list">
        </div>
        <script>
            const dragArea = document.querySelector(".wrapper");
            new Sortable(dragArea, {
                animation: 350
            });
        </script>
        <input type="Button" class='but small' id="next" onclick="chn()" value="Upload"></input>
    </div>
</section>
<script src="https://kit.fontawesome.com/3da1a747b2.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</body>

</html>