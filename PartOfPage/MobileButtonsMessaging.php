
<div class="MobileButtons">
    <button class="MobileButton" indexM="0">
        <p>Contacts</p>
    </button>
    <button class="MobileButton" indexM="1">
        <p>Messages</p>
    </button>
</div>

<script>

    var indexM = 1;

    $(".MobileButton").click(function(){
        indexM = $(this).attr('indexM');
        reducedDisplayM(indexM);
    });

    function reducedDisplayM(indexM){
        var widthM = screen.width;
        var tabs = ['.MessagingContact', '.Messaging'];
        if(widthM<=480) {
            for (i = 0; i < tabs.length; i++) {
                $(tabs[i]).hide();
            }
            $(tabs[indexM]).show();
        }else{
            for (i = 0; i < tabs.length; i++) {
                $(tabs[i]).show();
            }
        }
    }

    function sizeDisplayM() {
        var widthM = screen.width;
        if(widthM<=480){
            $('.MobileButtons').show();
        }else{
            $('.MobileButtons').hide();
        }
    }


    $(document).ready(function() {



        sizeDisplayM();
        reducedDisplayM(indexM);
        window.onresize = function (event) {
            sizeDisplayM();
            reducedDisplayM(indexM);
        };

    });
</script>