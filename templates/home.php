<div class="w-100 d-flex slideskins" style="max-width:100%;">
</div>
<div style="overflow: hidden;height:500px;max-width:100%;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="width: 100%;"><path d="M0.00,49.98 C149.99,150.00 271.49,-49.98 500.00,49.98 L500.00,0.00 L0.00,0.00 Z" style="stroke: none; fill: #E8E8E8;"></path></svg></div>
<!-- <center>
<div id="comslider_in_point_2376097" style="max-width:100%;"></div><script type="text/javascript">var oCOMScript2376097=document.createElement('script');oCOMScript2376097.src="https://commondatastorage.googleapis.com/comslider/target/users/1645778981x5c1b7dcd9d756819738f05c3068ce758/comslider.js?timestamp=1645828081&ct="+Date.now();oCOMScript2376097.type='text/javascript';document.getElementsByTagName("head").item(0).appendChild(oCOMScript2376097);</script>
</center> -->
<section>
    <div class="container" style="margin-top: -400px; position: sticky; background-color: rgb(255, 255, 255); box-shadow: rgb(66, 68, 90) 0px 0px 25px -6px inset;">
        <article>
            <div class="cases">
                <?php
                foreach($this->getEloq('cases','*') as $case){
echo<<<END
                <a href="Casee/{$case['id']}">
                <div class="case" style="-webkit-box-shadow: inset 1px 3px 15px 1px rgba(66, 68, 90, 1); -moz-box-shadow: inset 1px 3px 15px 1px rgba(66, 68, 90, 1); box-shadow: inset 1px 3px 15px 1px rgba(66, 68, 90, 1);">
                <div class="name" >{$case['name']}</div>
                    <div class="mx-auto image" style="background-image: url('{$this->gHost()}images/cases/{$case['image']}.png');">
                    <div class="price"><div class="inside">{$case['price']}PLN</div></div>
                    </div>
                </div>  
               </a>
END;

                }
                ?>
            </div>
        </article>
    </div>
</section>
<script>
    function slideprepend(i){
        $.post("Home",{
            slide_i:i
        },function(data,status){
            $('div.slideskins').prepend(data);
        });
    };

    $(function(){
        $("div.container").css({"margin-top":"-400px","position":"sticky","background-color":"#fff","box-shadow":"inset 0px 0px 25px -6px rgba(66, 68, 90, 1)"});

        for(var i=0; i<=6; i++){
            slideprepend(i);

        }

        setInterval(()=>{slideprepend(i); i++}, 3500);
    });
</script>