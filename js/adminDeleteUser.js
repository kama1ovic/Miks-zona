var del = $(".del");
del.click(function() {
    var id = $(this).data("id");
    console.log(id);
    $.ajax({
        url: "php/adminDeleteUser.php",
        method:"POST",
        data:{
            id:id,
            btn:"sent"
        },
        success:function(data, xhr){
            alert("Uspesno ste obrisali korisnika");
            location.reload();
        },
        error:function(xhr, status, error) {
            switch (xhr.status) {
                case 404:
                    window.location.href="../greska.php";
                    break;
                case 500:
                    alert("Izvinjavamo se zbog tehničkih problema");
                    break;
            }
        }
    });
});