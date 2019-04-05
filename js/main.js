$(document).ready(function() {
    //sakrivanje potkategorija
$('#left-side > ul > li').click(function () {
    $(this).find('li').toggle('hide');
});
    //vracanje na vesti (ponovno ucitavanje stranice)
    $(document).on("click",".refresh",function refresh(){
   location.reload();
});
    //slanje komenatara
    $(document).on("click","#btn-comment",function () {
   var user = $(this).data("user");
   var news = $(this).data("idnews");
   var commentValue = $('.comment-field').val();
   var errors = [];
   var er = $(".warning");
   var ok = $(".success");
   if((commentValue.length < 5) || (commentValue.length > 200)){
       errors.push("Greska!");
   }
   if(errors.length > 0) {
       ok.css("display","none");
       er.css("display","block");
   }
   else{
       $.ajax({
            url:"php/insertComment.php",
            method:"POST",

            data:{
                iduser : user,
                idnews : news,
                comment : commentValue,
                btn:"sent"
            },
            success:function (data) {
                er.css("display","none");
                ok.css("display","block");
            },
           error:function (xhr,status,error) {
               switch (xhr.status) {
                   case 422:
                       er.css("display","block");
                       ok.css("display","none");
                       break;
                   case 404:
                       window.location.href = "../greska.php";
                       break;
                   case 500:
                       alert("Izvinjavamo se zbog tehničkih problema");
                       break;
               }
           }
       });
   }
});
    //prikaz komentara
    $(document).on('click',".right",function (e) {
    var idnews = $(this).data("idnews");
    var user = $(this).data("user");
    var news = $(this).data("news");
    $.ajax({
        url:"php/getComments.php",
        method:"GET",
        dataType:"JSON",
        data:{
            id:idnews,
            btn:"sent"
        },
        success:function(data){
            var root = $("#articles");
            var com = "";
            if(data.sesija) {
                com = "<div id='comments'>";
                com += "<h3 class=' center'>"+news+"</h3>";
                com += "<form action='' method=''>";
                com += "<textarea id='comment' class='comment-field' ></textarea>";
                com += "<input type='button' data-idnews='" + idnews + "' data-user='" + user + "' class='comments-btn' id='btn-comment' value='Pošalji'>";
                com += "</form>";
                com += "<h5 class='warning'>Komentar mora imati izmedju 5 i 200 karaktera!</h5>";
                com += "<h5 class='success'>Komentar uspešno poslat.</h5>";
                com += "</form>";
                for(let i=0;i<data.vesti.length;i++) {
                    com += "<div class='comment'>";
                    com += "<h3 class='comment-user'>" + data.vesti[i].username +" " +data.vesti[i].datum+ "</h3>";
                    com += "<h5 class='comment-content'>" + data.vesti[i].komentar_tekst + "</h5>";
                    if(data.vesti[i].komentar_tekst != null)
                    com+= "<span class='anketa'>";
                    console.log(data.vesti[i].bingo);
                    console.log(user);
                    if(data.vesti[i].bingo == user) {
                        com += "<i class='green fa'> " + data.vesti[i].komentar_like + " </i><i class='red fa'> " + data.vesti[i].komentar_dislike + "</i>";
                    }
                    else {
                        com += "<i class='fa fa-thumbs-up' data-com='" + data.vesti[i].ID_komentar + "' data-user='" + user + "' data-news='" + data.vesti[i].ID_vest + "'> " + data.vesti[i].komentar_like + " </i>  <i class='fa fa-thumbs-down' data-user='" + user + "' data-news='" + data.vesti[i].ID_vest + "' data-com='" + data.vesti[i].ID_komentar + "'> ";
                        com += data.vesti[i].komentar_dislike + "</i></span>";
                    }
                    com+= "</div>";
                }
                com += "<h6 class='refresh'>Povratak na vesti</h6>";
                root.html(com);
            }
            else{
                com = "<div id='comments'>";
                for(let i=0;i<data.length;i++) {
                    com += "<div class='comment'>";
                    com += "<h3 class='comment-user'>" + data[i].username +" " +data[i].datum+ "</h3>";
                    com += "<h5 class='comment-content'>" + data[i].komentar_tekst + "</h5>";
                    com+= "<span class='anketa'>";
                    com += "<i class='green fa'> " + data[i].komentar_like + " </i><i class='red fa'> " + data[i].komentar_dislike + "</i>";
                    com+= "</div>";
                }
                com += "</div><h5 class='forbidden'><a  href='prijava.php'>Morate se ulogovati da biste komentarisali</a></h5>";
                com += "<h6 class='refresh'>Povratak na vesti</h6>";
                root.html(com);
            }
        },
        error:function (xhr, status, error) {
            switch (xhr.status) {
                case 404:
                    window.location.href = "../greska.php";
                    break;
                case 500:
                    alert("Izvinjavamo se zbog tehničkih problema");
                    break;
            }
        }
    });
});
//pretraga vesti
    $(document).on('keyup','#search',function (){
    var criteria = $('#search').val();
    $.ajax({
        url: "php/searchNews.php",
        method: "GET",
        dataType:"JSON",
        data: {
            news: criteria,
            btn: "sent"
        },
        success: function (data) {
            var root = $("#articles");
            var news = "";
            var tekst = "";
            if(data.sesija) {
                for (let i = 0; i < data.vesti.length; i++) {
                    news += "<div class='item'>";
                    tekst = data.vesti[i].vest_tekst;
                    news += "<div class='img'>" +
                        "<img src='" + data.vesti[i].slika + "' alt='" + data.vesti[i].vest_naziv + "' title='" + data.vesti[i].vest_naziv + "' width='200' height='150'>" +
                        "</div>";
                    news += "<div class='left-container'>";
                    news += "<div class='date-com'>";
                    news += "<h6 class='left'>" + data.vesti[i].datum + "</h6>";
                    news += "<h6 class='right' data-idnews='" + data.vesti[i].ID_vest + "' data-user='" + data.sesija.ID_korisnik + "' data-news='" + data.vesti[i].vest_naziv + "' >Komentari</h6>";
                    news += "</div>";
                    news += "<div class='details' data-idnews='" + data.vesti[i].ID_vest + "'><h3 class='heading'>" + data.vesti[i].vest_naziv + "</h3><p class='text'>" + tekst.substring(0, 150) + "...</p></div>";
                    news += "</div>";
                    news += "</div>";
                }
                root.html(news);
            }
            else{
                for (let i = 0; i < data.length; i++) {
                    news += "<div class='item'>";
                    tekst = data[i].vest_tekst;
                    news += "<div class='img'>" +
                        "<img src='" + data[i].slika + "' alt='" + data[i].vest_naziv + "' title='" + data[i].vest_naziv + "' width='200' height='150'>" +
                        "</div>";
                    news += "<div class='left-container'>";
                    news += "<div class='date-com'>";
                    news += "<h6 class='left'>" + data[i].datum + "</h6>";
                    news += "<h6 class='right' data-idnews='" + data[i].ID_vest + "' data-news='" + data[i].vest_naziv + "' >Komentari</h6>";
                    news += "</div>";
                    news += "<div class='details' data-idnews='" + data[i].ID_vest + "'><h3 class='heading'>" + data[i].vest_naziv + "</h3><p class='text'>" + tekst.substring(0, 150) + "...</p></div>";
                    news += "</div>";
                    news += "</div>";
                }
                root.html(news);
            }
        },
        error: function (xhr, status, error) {

            switch (xhr.status) {
                case 404:
                    window.location.href = "../greska.php";
                    break;
                case 500:
                    alert("Izvinjavamo se zbog tehničkih problema");
                    break;
            }
        }
    });
});
    //prikaz jedne vesti
        $(document).on('click','.details',function () {
        var user = $(this).data("user");
        var news = $(this).data("news");
        var idnews = $(this).data("idnews");
        //
        $.ajax({
            url: "php/showNews.php",
            method: "GET",
            dataType:"JSON",
            data: {
                id: idnews,
                btn: "sent"
            },
            success: function (data) {
                var root = $("#articles");
                var news = "<div class='news'>";
                if(data.sesija) {
                    for (let i = 0; i < data.vesti.length; i++) {
                        news += "<div>" +
                            "<img src='" + data.vesti[i].slika + "' alt='" + data.vesti[i].vest_naziv + "' title='" + data.vesti[i].vest_naziv + "' width='100%' height='300px'>" +
                            "</div>";
                        news += "<div class='left-container'>";
                        news += "<div class='date-com'>";
                        news += "<h6 class='left'>" + data.vesti[i].datum + "</h6>";
                        news += "<h6 class='right' data-idnews='" + idnews + "' data-user='" + data.sesija.ID_korisnik + "' data-news='" + data.vesti[i].vest_naziv + "'>Komentari</h6>";
                        news += "</div>";
                        news += "<div class='details no-underline' data-id='" + data.vesti[i].ID_vest + "'>";
                        news += "<h3 class='heading'>" + data.vesti[i].vest_naziv + "</h3>";
                        news += "<div class='text'><p>" + data.vesti[i].vest_tekst + "</p></div></div>";
                    }
                    news += "</div>";
                    root.html(news);
                }
                else{
                    for (let i = 0; i < data.length; i++) {
                        news += "<div>" +
                            "<img src='" + data[i].slika + "' alt='" + data[i].vest_naziv + "' title='" + data[i].vest_naziv + "' width='100%' height='300px'>" +
                            "</div>";
                        news += "<div class='left-container'>";
                        news += "<div class='date-com'>";
                        news += "<h6 class='left'>" + data[i].datum + "</h6>";
                        news += "<h6 class='right' data-idnews='" + idnews + "' data-news='" + data[i].vest_naziv + "'>Komentari</h6>";
                        news += "</div>";
                        news += "<div class='details no-underline' data-id='" + data[i].ID_vest + "'>";
                        news += "<h3 class='heading'>" + data[i].vest_naziv + "</h3>";
                        news += "<div class='text'><p>" + data[i].vest_tekst + "</p></div></div>";
                    }
                    news += "</div>";
                    root.html(news);
                }
            },
            error: function (xhr, status, error) {
                switch (xhr.status) {
                    case 404:
                        window.location.href = "../greska.php";
                        break;
                    case 500:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                }
            }
        });
    });
    //lajk komentara
        $(document).on("click",".fa-thumbs-up",function(){
        var news = $(this).data('news');
        var user = $(this).data('user');
        var com = $(this).data('com');
        var object = $(this);
        $.ajax({
            url:"php/like.php",
            method:"POST",
            data:{
                news :news,
                user : user,
                com : com,
                click:"sent"
            },
            success:function(data){
                object.html(" Vaš glas je zabeležen ");
            },
            error:function(x,s,e){
                switch (x.status) {
                    case 404:
                        window.location.href = "../greska.php";
                        break;
                    case 409:
                        object.html(" Već ste glasali! ");
                        break;
                    case 500:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                }
            }
        });
    });
    //dislike komentara
        $(document).on("click",".fa-thumbs-down",function(){
        var news = $(this).data('news');
        var user = $(this).data('user');
        var com = $(this).data('com');
        var object = $(this);
        $.ajax({
            url:"php/dislike.php",
            method:"POST",
            data:{
                news :news,
                user : user,
                com : com,
                click:"sent"
            },
            success:function(data){
                object.html(" Vaš glas je zabeležen ");
            },
            error:function(x,s,e){
                switch (x.status) {
                    case 404:
                        window.location.href = "../greska.php";
                        break;
                    case 409:
                        object.html(" Već ste glasali ");
                        break;
                    case 500:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                }
            }
        })
    });
    //prikaz komentara za korisnika
    $(document).on("click",".info",function () {
        var id = $(".info").data("id");
        var root = $("#articles");
        $.ajax({
            url:"php/getCommentsForOneUser.php",
            method:"GET",
            dataType:"JSON",
            data:{
                id : id,
                click : "sent"
            },
            success:function (data) {
                var com = "";
                if(data.length == ""){
                    com +="<h4 class='comment-heading'>Nemate nijedan komentar</h4>"
                }
                else {
                    com = "<h4 class='comment-heading'>Vaši komentari:</h4>";
                    for (let i = 0; i < data.length; i++) {
                        com += "<div class='comment'>";
                        com += "<h3 class='comment-user one'>" + data[i].username + " " + data[i].vest_naziv + " " + data[i].kom_datum + "</h3>";
                        com += "<h5 class='comment-content'>" + data[i].komentar_tekst + "</h5>";
                        com += "<span class='anketa'><i class='green fa'> " + data[i].komentar_like + " </i><i class='red fa'> " + data[i].komentar_dislike + "</i> <i data-user='" + data[i].ID_korisnik + "' data-com='" + data[i].ID_komentar + "' class='fas fa-trash-alt'></i></span>";
                        com += "</div>";
                    }
                }
                root.html(com);
            },
            error:function (x,s,e) {
                switch (x.status) {
                    case 404:
                        window.location.href = "../greska.php";
                        break;
                    case 409:
                        alert("Greška");
                        break;
                    case 500:
                        alert("Izvinjavamo se zbog tehničkih problema");
                        break;
                }
            }
        });
    });
    //brisanje komentara
    $(document).on('click','.fa-trash-alt',function (e) {
        e.stopPropagation();
        var com = $(this).data('com');
        var user = $(this).data('user');
        $.ajax({
            url:"php/deleteUserComment.php",
            method:"POST",
            dataType:"JSON",
            data:{
                com:com,
                user:user,
                click:"sent"
            },
            success:function (data) {
                alert("Uspešno ste obrisali komentar!");
                location.reload();
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