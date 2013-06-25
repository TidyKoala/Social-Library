# Social Library

Social Library is a web application for managing and sharing collections.

Who hasn't a collection? Of any sort. A book collection, a DVD collection, a CD collection, a coins collection...

Did you never accounter such situations:
- you are at a book shop. You are interested in a book you have in your hand but there is THE question: "Do I have it already or not?".
- you a looking for CD in shelves. You don't find it. The questions that come to your mind are :" Did I lost it?", "Did I lent it to someone?" and then follows those question: "Who did I lent it and when?"

This application is meant to resolve those problems.


## Privacy
Because we have at heart that your data belongs to you, everything is made so all your personnal data is safe. Your data isn't shared with anyone without your request. You can download all your data when ever you want.

## Contribute
As you can see by looking in the repository, the project is under developpement. The project is Open Source so anyone can contribute.

### Why?
Why should you contribute? There are many answers possible but here are perhaps the most important ones:

- You can make the application more secure
- You can make the application more reliable
- You can make the application more user-friendly
- You can add feature you wish
- ...

### What?
The projet is very recent, and as such there are many possible things to do.
There are many things to do :

- Add new medias types (CDs, coins, ...)
- Update the documentation
- Write tests
- Testing the application *in real world*
- Update translations
- Add new languages
- The design is very basic, so a nice and pratical design would be great
- ...

### How?
The steps to contribute are quite simple and easy. Before reading the next steps, Apache + PHP + MySQL+ git should be installed. 

1. Fork the repository to your account ([Fork tutorial of GitHub](https://help.github.com/articles/fork-a-repo))
2. Download the project on your computer: ```git clone https://github.com/*YourAccountName*/Social-Library.git```
3. Download [composer](http://getcomposer.org) to your projet directory: ```curl -sS https://getcomposer.org/installer | php```
4. Install all the librairies needed by project: ```php composer.phar update```
5. Copy the file ```app/config/parameters.yml.dist``` to ```app/config/parameters.yml``` and modify the database parameters so they correspond to your installation.
6. Create an account with SUPER ADMIN rights and answer the questions: ```php app/console fos:user:create --super-admin```
7. Install the database for the project: ```php app/console doctrine:schema:create```
8. If your project is your server public directory, you just need to go to http://localhost/SocialLibrary/ . If it is not the case, you must declare the new site to your server.
9. Tada! Social Library is available!


