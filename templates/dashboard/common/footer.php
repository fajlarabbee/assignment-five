<!--   Core JS Files   -->
<script src="<?php asset('/assets/js/core/popper.min.js'); ?>"></script>
<script src="<?php asset('/assets/js/core/bootstrap.min.js'); ?>"></script>
<script src="<?php asset('/assets/js/plugins/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?php asset('/assets/js/plugins/smooth-scrollbar.min.js'); ?>"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?php asset('/assets/js/material-dashboard.min.js?v=3.1.0'); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded',function(){
        console.log('loaded');
        var links = document.querySelectorAll(".delete-user");
        var rolesEdit = document.querySelectorAll('.edit-role');
        var linksLen = links.length;
        var rolesLength rolesEdit.length;
        for(let i=0;i<linksLen;i++){
            links[i].addEventListener('click',function(e){
                if(!confirm("Are you sure?")){
                    e.preventDefault();
                }
            });
        }

        for(let i = 0; i < rolesLength; i++) {
            rolesEdit[i].addEventListener('click', function(e){
                var id = this.getDataAttribute('data-id');
                console.log(id);
                e.preventDefault();
            });
        }
    });
</script>
</body>

</html>
