        $('#add-image').click(function(){
            //recuperation du nombre de form group
            const index = +$('#widgets-counter').val();

            //les protype des entrees
            const tmpl = $('#blog_imageBlogs').data('prototype').replace(/__name__/g, index);

            //injection du tmpl dans la div
            $('#blog_imageBlogs').append(tmpl);

            $('#widgets-counter').val(index + 1);

            //gestion du bouton suprimer
            handleDeleteButtons();
        });
        function handleDeleteButtons() {
            $('button[data-action="delete"]').click(function(){
                const target = this.dataset.target;
               // console.log(target);
                $(target).remove();
            })
        }
        function updateCounter() {
            const count = +$('#blog_imageBlogs div.form-group').length;
            $('#widgets-counter').val(count);
        }
        updateCounter();
        handleDeleteButtons();

        CKEDITOR.replace( 'blog_contenu', {
            extraPlugins: 'chart, pastecode',
            allowedContent : true
        } );
