/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getURLParameter(url, name) {
    return (RegExp(name + '=' + '(.+?)(&|$)').exec(url) || [, null])[1];
}

$(function() {

    /**
     * Delete Category
     */
    $('#category-delete').on('click', function(e) {
        e.preventDefault();
        var confirm_delete = confirm('Are you sure you want to delete this item?');

        if (confirm_delete) {
            var url = $(this).attr('href');
            var id = getURLParameter(url, 'cid');
            var params = {
                cid: id
            };

            $.ajax({
                type: 'POST',
                url: 'deletecategory.php',
                data: params
            }).done(function() {
                alert('item deleted');
            }).fail(function() {
                alert('item not deleted');
            });
        }
    });
});