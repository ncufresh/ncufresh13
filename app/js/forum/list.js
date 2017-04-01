
/**
 * Forum Main
 */
(function($)
{
    $(document).ready(function()
    {
        $.forum();
    });
})(jQuery);

(function($)
{
    $.forum = function(options)
    {
        if($('[name=initView]').length!=0 && !$('#forum_view_article_block_head').is(":visible"))
        {
            $.forum.openArticle($('[name=initView]').attr('id'));
        }

        $('div.forum_list_box').hide();
        $('div.forum_list_box[type=all]').show();

        //Handle events below
        $('.forum_all_container').on('hover', '.forum_eff_btn', function(){
            $(this).css('opacity', '0.5');
        });

        $('.forum_all_container').on('mouseleave', '.forum_eff_btn', function(){
            $(this).css('opacity', '1');
        });

        // for create article
        $('.forum_all_container').on('click','.forum_new_post_btn_img_div', function(){
            if(isLogIn())
            {
                $.ajax({
                    url: bUrl+"/forum/create.html",
                    beforeSend: function(){
                        if($("#article_form").length!=0)
                            return false;
                        return true;
                    },
                    error: function(){ alertMsg('無法傳送請求，請重新整理頁面','Error','error')},
                    success: function(html){
                        animateClose('forum_view_article_block',true,true,html,'forum_new_post_block');
                        //$.forum.goTop();
                    }
                });
            }
            else
                alertMsg('請先登入','Error','error');
            
        });

        $('.forum_all_container').on('click','.forum_new_post_btn[type=reset]', function(){
            animateClose('forum_new_post_block');
        });

        $('.forum_all_container').on('click','#new_post_title',function(){
            if($(this).val()=='請輸入標題')
            {
                $(this).val('');
            }
        });

        //submit article
        $('.forum_all_container').on('submit','#article_form',function(){
            $.ajax({
               type: "POST",
               url: bUrl+'/forum/create.html',
               //
               data: $("#article_form").serialize(), // serializes the form's elements.
               error: function(){ alertMsg('無法傳送請求，請重新整理頁面','Error','error')},
               success: function(data)
               {
                    if(data.trim().substr(0,1)=='a')// succedd to post
                    {
                        var str_id = data.trim().substr(1);
                        if(isNaN(str_id))
                            alertMsg('未知錯誤，請嘗試重整頁面','error','error');
                        $.forum.openArticle(parseInt(str_id));
                        switchTag.call($('div.forum_tag_div[type=newest]'), true);
                    }
                    else
                    {
                        $('.forum_new_post_content_bg').find('img#loading').remove();
                        $('.forum_new_post_content_bg').find('form').css({'opacity': 1});
                       alertMsg(data,'error','error');
                    }
               }
            });
            return false;
        });

        //submit search
        $('.forum_all_container').on('submit','#forum_search_form',function(){
            $.ajax({
               type: "POST",
               url: bUrl+'/forum/search.html',
               data: $("#forum_search_form").serialize(), // serializes the form's elements.
               error: function(){ alertMsg('無法傳送請求，請重新整理頁面','Error','error')},
               success: function(data)
               {
                    switchTag.call($('div.forum_tag_div[type=search]'));
                    $('div.forum_list_box[type=search]').html(data);
               }
            });
            return false;
        });

        //Edit article
        $('.forum_all_container').on('click', '.forum_article_edit_link', function(){
            $('.forum_article_edit').show();
            $('.forum_article_view').hide();
            return false;
        });

        //Cancle edit
        $('.forum_all_container').on('click', '.forum_article_edit_btn_cancel', function(){
            $('.forum_article_edit').hide();
            $('.forum_article_view').show();
            return false;
        });

        //Edit comment link
        $('.forum_all_container').on('click', '.forum_comment_edit_link', function(){
            var id = $(this).attr('cid');
            $('.forum_comment_edit[cid='+id+']').show();
            $('.forum_comment_view[cid='+id+']').hide();
            return false;
        });

        //submit edit comment edit
        $('.forum_all_container').on('submit', '#forum_comment_edit_form', function(){
            var id = $('.forum_article_view_title_row').attr('aid');
            var cid = $(this).attr('cid');
            $.ajax({
                    url: bUrl+'/forum/'+$(this).attr('action'),
                    data: $(this).serialize(),
                    type: 'POST',
                    error: function(){ alertMsg('無法傳送請求，請重新整理頁面','Error','error')},
                    success: function(html){
                        if(!$.forum.checkResponse(html))
                            return;
                        if(html.trim().length===0)// succedd to post
                        {
                            refreshArticle();
                            $('.forum_add_comment_form_box').slideUp();
                            refreshNowList();
                            // switchTag.call($('div.forum_tag_div[type=all]'));
                        }
                        else
                        {
                            alertMsg(html, 'error', 'error');
                        }
                    }
                });
            return false;
        });

        //Cancle edit comment
        $('.forum_all_container').on('click','.forum_comment_edit_btn_cancel',function(){
            var id = $(this).attr('cid');
            $('.forum_comment_edit[cid='+id+']').hide();
            $('.forum_comment_view[cid='+id+']').show();
        });

        //submit Edit article form submit
        $('.forum_all_container').on('submit', '#forum_article_edit_form', function(){
            var id = $('.forum_article_view_title_row').attr('aid');
            $.ajax({
                type: 'POST',
                url: bUrl+'/forum/'+$("#forum_article_edit_form").attr('action'),
                data: $("#forum_article_edit_form").serialize(),
                error: function(){ alertMsg('無法傳送請求，請重新整理頁面','Error','error')},
                success: function(html){
                    if(html.trim().length===0)// succedd to post
                    {
                        refreshArticle();
                        refreshNowList();
                        // switchTag.call($('div.forum_tag_div[type=all]'));
                    }
                    else
                    {
                        alertMsg(html,'error','error');
                    }
                        
                } 
            });
            return false;
        });
        
        //Add comment
        $('.forum_all_container').on('submit', '#forum_add_comment_form', function(){
            var id = $('.forum_article_view_title_row').attr('aid');
            $.ajax({
                type: 'POST',
                url: $("#forum_add_comment_form").attr('action'), //already match router
                data: $("#forum_add_comment_form").serialize(),
                error: function(){ alertMsg('無法傳送請求，請重新整理頁面','Error','error')},
                success: function(html){
                    if(html.trim().length===0)// succedd to post
                    {
                        $.forum.openArticle(id);
                    }
                    else
                    {
                        $('div.forum_add_comment_form_box.forum_article_view_content_box').find('img#loading').remove();
                        $('div.forum_add_comment_form_box.forum_article_view_content_box').find('form').show();
                        alertMsg(html,'error','error');
                    }
                        
                } 
            });
            return false;
        });
        
        //Delete article
        $('.forum_all_container').on('click','div.forum_article_delete',function(){
//TODO beautiful comfirm
            if(confirm('確定要刪除文章嗎，將會一併刪除回復！'))
            {
                $.ajax({
                    data:"id="+$('.forum_article_view_title_row').attr('aid'),//+"&YII_CSRF_TOKEN="+$('input[name=YII_CSRF_TOKEN]').val(),
                    url: bUrl+'/forum/deleteArticle.html',
                    error: function(){ alertMsg('無法傳送請求，請重新整理頁面','Error','error')},
                    success:function(data){
                        if(data.trim().length==0)
                        {
                            alertMsg('成功刪除文章','success','normal'),
                            animateClose('forum_view_article_block');
                            refreshNowList();
                        }
                        else
                        {
                            alertMsg('無法刪除文章','Error','error');
                        }
                    }
                });
            }
        });

        //Delete comment
        $('.forum_all_container').on('click','div.forum_comment_delete',function(){
//TODO beautiful comfirm
            if(confirm('確定要刪除回復嗎？'))
            {
                $.ajax({
                    data:'id='+$(this).attr('cid'),
                    url: bUrl+'/forum/deleteComment.html',
                    error: function(){ alertMsg('無法傳送請求，請重新整理頁面','Error','error')},
                    success:function(data){
                        if(data.trim().length==0)
                        {
                            refreshArticle();
                        }
                        else
                        {
                            alertMsg('無法刪除回覆','Error','error')
                        }
                    }
                });
            }
        });

        var refreshArticle = function(){
            var id = $('.forum_article_view_title_row').attr('aid');
            $.forum.openArticle(id);
        }

        //for tab change
        $('div.forum_tag_div').hover(function(){
            if($(this).find('img.select').is(":visible"))
                return false;
            $(this).find('img.none').hide();
            $(this).find('img.hover').show();
        });

        $('div.forum_tag_div').mouseleave(function(){
            if($(this).find('img.select').is(":visible"))
                return false;
            $(this).find('img.none').show();
            $(this).find('img.hover').hide();
        });

        //img button add comment
        $('.forum_all_container').on('click','div.forum_article_view_comment_btn',function(){
            if(isLogIn())
            {
                $('.forum_add_comment_form_box').slideDown().delay(500);
                goTop(null,null,null,(-$('.forum_add_comment_form_box').position().top));
                // $('#bodywrapped').css('top', -$('.forum_add_comment_form_box').position().top);
                setTimeout('$.bar($("#bodyscroll"))', 1000);
            }
            else
                alertMsg('請先登入','請先登入','error');
        });

        var isLogIn = function(){
            if($('#login-form').length==0)
            {
                return true;
            }
            return false;
        };

        var refreshNowList = function(){
            $('div.forum_list_box').each(function(a, b){
                if($(b).is(":visible"))
                {
                    switchTag.call($('div.forum_tag_div[type='+$(b).attr('type')+']'), true);
                }
            });
        };

        var switchTag = function(force){
            var force = force || false;
            // console.log('switchTag');
            var type = $(this).attr('type');
            if(force!== true && $(this).find('img.select').is(":visible"))
                return false;
            $('div.forum_list_box').html('');
            $('img.forum_each_tag.select').hide();
            $('img.forum_each_tag.hover').hide();
            $('img.forum_each_tag.none').show();
            $(this).find('img.none').hide();
            $(this).find('img.select').show();
            
            $('div.forum_list_box').hide();
            $('div.forum_list_box[type='+type+']').show();

            var action = 'Ajax' + type + 'Article';
            if(type=='search')
            {
                $('#forum_search_form').submit();
                return false;
            }
                // action = 'search';
            $.ajax({
               url: bUrl+'/forum/'+action+'.html',
                error: function(){ alertMsg('無法傳送請求，請重新整理頁面','Error','error')},
                success: function(html){
                    $('div.forum_list_box[type='+type+']').html(html);
                },
                complete: function(){
                    $('div.forum_list_box[type='+type+']').find('img#loading').remove();
                }
            });
            return false;
        };

        $('#forum_body_inside').ajaxComplete(function(){
            $(this).find('img#loading').remove();
        });

        $('#forum_body_inside').ajaxSend(function(a,b,c) {
          var url=(c.url).toLowerCase();
          console.log(url);
          if(url.search('viewgridcomment')>0)
          {
            $('.forum_view_article_comments_list').animate({opacity:0}, 1000);
            goTop();
            return;
          }
          if(url.search('view')>0&&url.search('article_page')<0)
          {
            $('div.forum_add_comment_form_box.forum_article_view_content_box').find('img#loading').remove();
            $('div.forum_add_comment_form_box.forum_article_view_content_box').find('form').hide();
            $('div.forum_add_comment_form_box.forum_article_view_content_box').append('<img id="loading" src="'+bUrl+'/file/img/forum/loading.gif">');
            return;
          }
          if(url.search('create')>0)
          {
            $('.forum_new_post_content_bg').find('img#loading').remove();
            $('.forum_new_post_content_bg').find('form').css({'opacity': 0});
            $('.forum_new_post_content_bg').prepend('<img id="loading" src="'+bUrl+'/file/img/forum/loading.gif">');
            return;
          }
          if(url.search('delete')>0)
            return;
          if(url.search('article')==-1&&url.search('search')==-1)
            return;
          $(this).find('.grid-view').hide();
          $(this).find('img#loading').remove();
          $(this).find('.forum_list_box').append('<img id="loading" src="'+bUrl+'/file/img/forum/loading.gif">');
        });

        $('div.forum_tag_div').click(switchTag);
    };

    $.forum.attachBarToContent = function(){
        $.each($('.forum_article_view_content_inner.forum_content'), function(){
            if(parseInt($(this).css('height'))>155)
                $.bar($(this).parent());
        });
    };

    $.forum.checkResponse = function(html){
        if(html.trim().substr(0,5)=='error')// succedd to post
        {
            var err_msg = html.trim().substr(5);
            alertMsg(err_msg, 'error', 'error');
            return false;
        }
        return true;
    };

    $.forum.openArticle = function(id)
    {
        $.ajax({
            url: bUrl+'/forum/view.html',
            data: {'id': id},
            error: function(){alertMsg('無法開啟文章，請重新整理頁面','Error','error')},
            success: function(html){
                //$.forum.goTop();
                //console.log(html.trim().substr(0,5));
                if($.forum.checkResponse(html))
                {
                    animateClose('forum_new_post_block',true,true,html,'forum_view_article_block');
                    setTimeout('$.forum.attachBarToContent()',1500);
                }           
            }
        });
    }
})(jQuery);
