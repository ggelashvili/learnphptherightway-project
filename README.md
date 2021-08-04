#### The exercise for the PHP course "Learn PHP The Right Way" lesson 2.33.

---
#### Course Playlist
https://www.youtube.com/watch?v=sVbEyFZKgqk&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-

---
#### Summary
At the end of the section 1 of the course we did a mini project & exercise where we built a transaction file importer. We did it procedural way & also read the files from directory instead of letting user upload them. This exercise is for you to implement the same thing but use OOP as well as database to store the imported transactions & then display them on the screen like this:
![Sample Output](result.png)

I have provided you with the skeleton of code that you can work with, it is what we already covered in the second section of the course (in the last few lessons). You can refer to [this video](https://youtu.be/iCKzIIE4w5E) to understand the structure of the code. Note that you can write the whole thing on your own & don't use this structure at all, the goal is to simply accept a file upload of transactions, save them in transactions table & color code expense/income when displaying the transactions table. You can look at the code that I wrote & explained in [this video](https://youtu.be/MOsolLaVnsI) & convert it into OOP if you wish.

---
#### Instructions
1. Clone this repository to your local or download it.
2. If you are using docker you can `cd` into the docker directory & run `docker-compose up -d`. If you are using something else like XAMPP just make sure you have Web Server (Apache), PHP & MySQL running.
   * Please note that **PHP 8** is required if you want to use the skeleton that I am providing. You will need to adjust the code to make it work for lower PHP versions.
3. Create a `.env` file by copying variables from `.env.example`. Fill in those values in `.env` file.
4. Make sure that whatever database name you enter actually exists, if not, create that database.
5. Confirm that once you open your `http://localhost:8000` it loads the home page.
6. Create a new route & controller that will let you upload the transactions CSV file. The UI is not important, so you don't even need any CSS. If you want you can use `HomeController` and simply add a new method and route for it or create a new controller entirely.
7. Your controller should accept the uploaded file, read it line by line & save the data into the **transactions** table. You can download the sample transactions file to upload [here](https://raw.githubusercontent.com/ggelashvili/learnphptherightway-project/1.32/transaction_files/sample_1.csv)
   * Create the **transactions** table with appropriate columns to store the data
   * Create a model within the **Models** directory to actually process the file & save data into the database
   * First column is the date of the transaction
   * Second column is the check # which is optional & is not always provided
   * The third column is transaction description
   * The fourth column is the amount (negative number indicates it's an expense, positive number indicates it's an income), it's up to you how you want to store it
8. The view file is provided for you under `views/transactions.php` you just need to render this from your controller & pass down the necessary data to display transactions.
   * The date of the transaction should be in this format "Jan 4, 2021"
   * Show income amounts in green color & show expense amounts in red
9. Submit the PR with your changes, I will review & provide feedback, if you get stuck or have any questions let me know.
10. **Bonus:** Allow multiple file uploads so that more than one CSV file can be uploaded at the same time.
