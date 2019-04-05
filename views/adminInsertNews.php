<title>Dodaj vest</title>
</head>
<body>
<div id="wrapper">
    <div class="box" >
        <div id="errors">
        <?php if(isset($_SESSION['ok'])) : ?>
            <p class="feedbackAdmin ok"><?=$_SESSION['ok']?></p>
        <?php endif; unset($_SESSION['ok']); ?>
            <?php if(isset($_SESSION['errors'])) :
                foreach ($_SESSION['errors'] as $error) :?>
                <p class="feedbackAdmin er"><?=$error?></p>
            <?php endforeach; endif; unset($_SESSION['errors']);  ?>
        </div>
        <div id="header">
            <h3>Dodaj vest</h3>
        </div>
        <div id="edit-news" class="admin">
            <form id="forma2" action="php/adminInsertNews.php" method="POST" enctype="multipart/form-data">
                <p class="left">Izaberi kategoriju</p>
                <select class="right select" id="category" name="category" >
                    <option value="0">Izaberite...</option>
                    <?php
                    $query = "SELECT * FROM link WHERE ID_link_parent = 0";
                    $sum = select($query);
                    foreach ($sum as $link): ?>
                        <option  value="<?=$link->ID_link?>"><?=$link->naziv?></option>
                    <?php endforeach; ?>
                </select>
                <p class="left">Izaberi potkategoriju</p>
                <select class="right select" id="subcategory" disabled="disabled" name="subcategory">
                </select>
                <p class="left">Naslov</p>
                <input type="text" class="right" name="heading" autofocus="autofocus" />
                <p class="left">Tekst</p>
                <textarea name="text" cols="30" rows="10"></textarea>
                <p class="left">Slika</p>
                <input class="right" type="file" name="img" >
                <input type="submit" value="Dodaj" class="btn btn2" name="btn"/>
            </form>
        </div>
        <footer>
            <h5><a href="admin.php?page=pocetna">Nazad na početnu stranu</a></h5>
        </footer>
    </div>
    </div>
<script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#category').change(function() {
           var cat =  $(this).val();
           console.log(cat);
           var subSelect = document.getElementById("subcategory");
           $.ajax({
              url:"php/adminInsertNewsGetSubcat.php",
              method:"GET",
              dataType:"JSON",
              data:{
                  cat:cat,
                  change:"sent"
              },
              success:function (data) {
                  if(cat==0) {
                      subSelect.setAttribute("disabled", "disabled");
                      subSelect.innerHTML = "";
                      return false;
                  }
                  subSelect.removeAttribute("disabled");
                  subSelect.setAttribute("enabled","enabled");
                  console.log(data);
                  var subcategories = "";
                  for (var i = 0;i<data.length;i++){
                      subcategories += "<option value='"+data[i].ID_link+"'>"+data[i].naziv+"</option>";
                  }
                  subSelect.innerHTML = subcategories;
              },
              error:function (x,s,e) {
                  switch (x.status) {
                      case 404:
                          window.location.href = "../greska.php";
                          break;
                      case 409:
                          alert("Nije moguće obrisati komentar");
                          break;
                      case 500:
                          alert("Izvinjavamo se zbog tehničkih problema");
                          break;
                  }
              }
           });
        });
    });
</script>