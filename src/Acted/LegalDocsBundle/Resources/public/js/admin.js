/**
 * Created by pavel on 03.07.16.
 */
$(function() {
    $(document).on('click','.manageRecommended',function(){
        //console.log(this)
        var artistEditManageId = $(this).parents('tr').attr('id');
        //console.log(artistEditManageId)
        $('tr#'+artistEditManageId+' .recommendedIndexAdmin').hide();
        $('tr#'+artistEditManageId+' .recommendedInput').show();
        $('tr#'+artistEditManageId+' .saveRecommended').show();
        $('tr#'+artistEditManageId+' .manageRecommended').hide();
    })

    $(document).on('click','.saveRecommended',function(){
        //console.log(this)
        var artistEditManageId = $(this).parents('tr').attr('id');
        //console.log(artistEditManageId);
        var recommendedCat = $('#catMainSel option:selected').val();
        var artistREcommendedVal = $('tr#'+artistEditManageId+' .recommendedInput').val();
        $.ajax({
            type: "POST",
            url: '/administration/manage_recommend',
            data: {"value": artistREcommendedVal,
                   "artist": artistEditManageId,
                   "category": recommendedCat},
            success: function(){
                $('tr#'+artistEditManageId+' .recommendedIndexAdmin').show().text(artistREcommendedVal);
                $('tr#'+artistEditManageId+' .recommendedInput').hide();
                $('tr#'+artistEditManageId+' .saveRecommended').hide();
                $('tr#'+artistEditManageId+' .manageRecommended').show();
            }
        });
    })


    $(document).on('click','.manageSpotlight',function(){
        //console.log(this)
        var artistEditManageId = $(this).parents('tr').attr('id');
        //console.log(artistEditManageId)
        $('tr#'+artistEditManageId+' .spotlightIndexAdmin').hide();
        $('tr#'+artistEditManageId+' .spotlightInput').show();
        $('tr#'+artistEditManageId+' .saveSpotlight').show();
        $('tr#'+artistEditManageId+' .manageSpotlight').hide();
    })

    $(document).on('click','.saveSpotlight',function(){
        //console.log(this)
        var artistEditManageId = $(this).parents('tr').attr('id');
        //console.log(artistEditManageId);
        var artistREcommendedVal = $('tr#'+artistEditManageId+' .spotlightInput').val();
        $.ajax({
            type: "POST",
            url: '/administration/manage_spotlight/'+artistEditManageId,
            data: {"spotlight": artistREcommendedVal},
            success: function(){
                $('tr#'+artistEditManageId+' .spotlightIndexAdmin').show().text(artistREcommendedVal);
                $('tr#'+artistEditManageId+' .spotlightInput').hide();
                $('tr#'+artistEditManageId+' .saveSpotlight').hide();
                $('tr#'+artistEditManageId+' .manageSpotlight').show();
            }
        });
    })
});