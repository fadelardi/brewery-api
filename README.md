# Distilled SCH Beer App

**Tech Stack**

- PHP 5.6.30
- PHPUnit 5.7.14 
- vanilla javascript 
- bootstrap (css only)

**Starting the Project** 

Running PHP Unit: 

```
phpunit --bootstrap autoload.php tests/ 
```

Adding your Brewery API key:

```
classes/BreweryAPI.php:24
```

**Regarding my approach for this challenge**

I could have made this challenge with PHP/HTML only (which I orginally did). I could have made this challenge with js/html only (which I really wanted to...). But like the PDF said, this is not about taking the shortest route; this is a testament of one's abilities. As such, I chose to use both, even if it seems redundant at points, or overly complex at others. I also chose not use any framework/library (aside from bootstrap, because styling was not a focus ). First, I like keeping the boilerplate to a minimum, second, it would have only proven I could use a given framework, and third, it would have been overkill (in my opinion).       

**Opportunity for Improvement**

As programmers, we are rarely satisfied with our work. Especially when there are time constrains. But at some point, "perfection" has to be put aside for "practicality", and so we must release what we do into the wild. I am fully aware that however small this project is, there could definitely be some improvements. Some of these are:

- Better Unit Tests (PHP): unfortunately I did not test everything that could be tested thoroughly. 
- PSR2 standard & namespaces
- Unit tests for my javascript "class": it would've required the presence of more boilerplate to use mocha/jasmine 
- Dependency management: my project a vanilla stack for the most part, but I could added those files anyway
- Better styling 

**Versioned**

I have used git for this small coding challenge as much for my convenience, as yours. Should you wish to do so, you can check the evoluation of the code from its inception.

**Thanks**

Thank you for giving me this opportunity. It was a fun challenge.  
