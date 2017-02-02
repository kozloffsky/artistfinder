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
    });

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
    });
    $(document).on('click', '.deleteUser', function(){
        var userRow = $(this).parents('tr'),
            username = $(userRow).find('.usernameAdmin').text(),
            userId = $(userRow).attr('id'),
            wordToDelete = 'Delete';
        var userDeletechoice = prompt('Enter "'+wordToDelete+'" if you want to delete '+username+'');
        if(userDeletechoice == wordToDelete){
            deleteUser(userId)
        }
    });

    $(document).on('change', '.userStatusAd', function() {
        var userRow = $(this).parents('tr'),
            username = $(userRow).find('.usernameAdmin').text(),
            userId = $(userRow).attr('id'),
            userStatus = $(this).prop('checked');
        if(userStatus == true){
            var status = 'activate';
        } else {
            var status = 'deactivate';
        }
        changeStatus(userId, status)
    });

    $(document).on('change', '.userStatusFakeAd', function() {
        var userRowFake = $(this).parents('tr'),
            usernameFake = $(userRowFake).find('.usernameAdmin').text(),
            userIdFake = $(userRowFake).attr('id'),
            userStatusFake = $(this).prop('checked');
        if(userStatusFake == true){
            var statusFake = 'isFake';
        } else {
            var statusFake = 'isNotFake';
        }
        changeStatusFake(userIdFake, statusFake)
    });

    $(document).on('click', '.editMailAdmin', function () {
        var userRow = $(this).parents('tr'),
            userId = $(userRow).attr('id');
        $(userRow).find('.userEmail, .editMailAdmin').hide();
        $(userRow).find('.userEmailChange, .saveMailAdmin').show();
    });

    $(document).on('click', '.saveMailAdmin', function () {
        var userRow = $(this).parents('tr'),
            userId = $(userRow).attr('id'),
            email = $(userRow).find('.userEmailChange').val();
        $.ajax({
            type: "POST",
            url: '/administration/users/change_email/'+userId,
            data: {'email':email},
            success: function(){
                $('.error_'+userId).text('');
                $(userRow).find('.userEmail, .editMailAdmin').show();
                $(userRow).find('.userEmailChange, .saveMailAdmin').hide();
                $(userRow).find('.userEmail').text(email);
                window.location.reload();
            },
            error: function(res){
                $('.error_'+userId).text();
                $('.error_'+userId).text(res.responseJSON.error);
            }
        });
    });

    function deleteUser(userId){
        $.ajax({
            type: "DELETE",
            url: '/administration/users/delete/'+userId,
            success: function(){
                $('tr#'+userId+'').remove();
            }
        });
    }

    function changeStatus(userId, status){
        $.ajax({
            type: "POST",
            url: '/administration/users/change_status/'+userId,
            data: {'status':status},
            success: function(){

            }
        });
    }

    function changeStatusFake(userId, status){
        $.ajax({
            type: "POST",
            url: '/administration/users/change_status_fake/'+userId,
            data: {'fake':status},
            success: function(){

            }
        });
    }

    $(document).on('click', '.tokenResendUser', function() {
        var userRow = $(this).parents('tr'),
            userId = $(userRow).attr('id');

        sendToken(userId)
    });

    function sendToken(userId){
        $.ajax({
            type: "POST",
            url: '/administration/users/resend_confirmation_token/'+userId,
            success: function(response){
                alert(response.success)
            }
        });
    }
});