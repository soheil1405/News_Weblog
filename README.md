# installation

```bash
 git pull https://github.com/soheil1405/News_Weblog.git
```

```bash
 composer install
```

```bash
 php artisan migrate
```

```bash
 php artisan test
```

# apis
##
## news , news tags  , news rections(by ip)
##
1. store news   : (post)


```bash
http://127.0.0.1:8000/api/news
```
- title(persian , unique )

- pre_description( persian) ,

- body

-  tags : for example ( خبر ، خبر جدید ) (that is important to use "," between two tags , because it is seprator ... if tag exists before just it will make relation ... either it will create new one and make relation )

- image : if you select an image ... it will save a new one in storage s3 in your cloud (as mr vahid sail ) else it will not save image but it will store defualt news image name that i saved bofore
        
    
4. update news  : (put)


```bash
 http://127.0.0.1:8000/api/news/{id}
```

  - just like store news

6. get all news : (get)

```bash
   http://127.0.0.1:8000/api/news
````

  - get all data from NewsIndexResource

5. get news by tags : (gte)

```bahs
http://127.0.0.1:8000/api/news/tagId={tagid}
```


7. show news    : (get) 
```bash
http://127.0.0.1:8000/api/news/{id}
```

- get this news from ShowNewsResource

- also get your last reaction to this news (stored by ip)     

-  get all this news likes and disslike count

- get all accepted comments in from CommentResource and also their accepted answers and also their reaction count and also your reaction status to specif comment (by ip , just like news reactions)

-# attenion:just accepted comments will be shown
   
8. reaction to news : (post)
```bash
   http://127.0.0.1:8000/api/news/reaction/{news}
````
- required : reaction : allwed( 1:like or -1:disslike)

- it will manage from your ip

- in the column likeOrDissLikeJsonData in comments table(and also news table , thats just like this in it will use this functions) it will be save that which user with what ip has been racted to whitch comment and what was that reaction

- if user liked before and clicked to like again(her like will be cancell becase it was exists in likeOrDissLikeJsonData and saved by ip before)

- else if user liked before and clicked to disslike again(her like will be cancell  and also her new reaction would be disslike to that ...  becase it was exists in likeOrDissLikeJsonData and saved by ip before)

- if user dissliked before and clicked to disslike again(her disslike will be cancell becase it was exists in likeOrDissLikeJsonData and saved by ip before)

- else if user disslike before and clicked to like again(her disslike will be cancell  and also her new reaction would be like to that ...  becase it was exists in likeOrDissLikeJsonData and saved by ip before)

- this reactions will be count and save into like or disslike count for this comment or this news

- this part was developed in app/Helpers/basicHelpers.php and called in comment.php model and also in news.php model


11. delete news : (DELETE)
```bash
http://127.0.0.1:8000/api/news/destroy/{news}
```
- i could use soft delete too

- delete all commens and also thats answers

- deacrease tags count(the count of news are storing in tags and when news will be delete , the have to decrease theire count)

- detach tags and news

- news image  unlink (if image was not defualt image)

- news delete
    
####

# comments , accept comment , reaction to comment , answer commnet , delete comment

9. store comment : (post)

```bash
     http://127.0.0.1:8000/api/comments/save/   
```

- news_id

- answered_to : nullable ( comment id )

- witer 

- comment_body : persian

- if answered to exists , it will be answer to that comment else ot means it is a new comment 

- comment will be shown when it will be accept 



11. accept comment: (PUT)

```bash
 http://127.0.0.1:8000/api/comments/acceptComment/{comment}
```
- it will change thw status column in comments from new to yes

- it will increase the news comment count



11.delete comment : (DELETE)  

```bash
http://127.0.0.1:8000/api/comments/destroy/{comment}

```
- delete comment answers

- delet comment

- decrease its news comment count (count answers + 1)


    
12. comment reaction : (POST)

```bash
http://127.0.0.1:8000/api/comments/reaction
```
- it will work just like news reaction  (5) (by ip and json data)

   
```bash
 Soheil Amini taghdim with Love
```
