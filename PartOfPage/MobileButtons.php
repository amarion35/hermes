
<div class="MobileButtons">
    <button class="MobileButton" index="0">
        <p>Menu</p>
    </button>
    <button class="MobileButton" index="1">
        <p>My Wall</p>
    </button>
    <button class="MobileButton" index="2">
        <p>Notifications</p>
    </button>
</div>

<script>

    var index = 1;

    $(".MobileButton").click(function(){
        index = $(this).attr('index');
        reducedDisplay(index);
    });

    function reducedDisplay(index){
        var width = screen.width;
        var tabs = ['.LeftSide', '.Center', '.RightSide'];
        if(width<=480) {
            for (i = 0; i < tabs.length; i++) {
                $(tabs[i]).hide();
            }
            $(tabs[index]).show();
        }else{
            for (i = 0; i < tabs.length; i++) {
                $(tabs[i]).show();
            }
        }
    }

    function sizeDisplay() {
        var width = screen.width;
        if(width<=480){
            $('.MobileButtons').show();
        }else{
            $('.MobileButtons').hide();
        }
    }


    $(document).ready(function() {



        sizeDisplay();
        reducedDisplay(index);
        window.onresize = function (event) {
            sizeDisplay();
            reducedDisplay(index);
        };

    });
</script>