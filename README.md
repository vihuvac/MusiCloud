Music in the Cloud Website
==========================

This document provides a simple and straightforward description of how to work on the
website repository. Some rules explained here where not always in place, so coders that
find code that doesn't comply with them **must** report them and is encouraged to fix them.

If you find errors in this document, please submit a pull request with the changes.


1) Installing
-------------

Install composer:

    curl -s https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin

Go into the root folder of the project and run:

    php app/check.php

Fix any errors that you may encounter there.
When that's finished, run:

    composer.phar install

That will install all the external libraries.

2) Workflow
-----------

To work on the website you need to fork the base repository into your github account. NEVER commit to the
base repository directly.

Whenever a new feature/fix/improvement/whatever is requested/proposed, you FIRST need to create an
issue in [GITHUB](https://github.com/vihuvac/website) if that is not already made.

After you get the issue code (e.g. WEBSITE-999), you create a local branch with that name

    git checkout -b WEBSITE-999

Then you proceed to work, **committing (and preferably pushing) OFTEN**, and when it's done you
open a new pull request. It's recommended you send a message by mail (related to that pull request, if you didn't get the feedback as soon as possible) asking all devs to code-review it.
Once the code-review is done, the issue is merged, and the local branch can be deleted.


3) Coding Standards:
--------------------

We embrace the PSR-2, PSR-1, and PSR-0 coding standards (as does Symfony2).
**Never**, under no circunstance a pull request should be requested if the code was not checked first
by phpcs using the PSR2 standard.
To setup phpcs, run the following commands:

    sudo pear install PHP_CodeSniffer-1.4.3
    phpcs --config-set default_standard PSR2

To check a file or a full directory just run:

    phpcs src/Vihuvac #For a full directory
    phpcs src/Vihuvac/Bundle/DataBundle/DataBundle.php #For a file

You could just check the files that where modified (really useful to run before committing):

    git status --porcelain | cut -f 3 -d ' ' | xargs phpcs


4) Code reviews:
----------------

Every code that goes into the vihuvac/website repo MUST PASS code-review.
It's important that as many people as possible participate in every code-review process and
that people are encouraged to comment on anything they think might be improved, even if someone
else proves them wrong later. We need to encourage people to not be afraid of being mistaken both
when requesting a code-review and when performing one.


5) Pull requests:
-----------------

Pull requests are usually done against the vihuvac/website repo, but might be done to
one of the forks in case of another person wanting to propose a fix to a WIP branch.
Even though pull requests are usually opened when the code is done, it might be better to open
the PR ahead of time in some cases, especially bigger issues that are hard to separate in smaller PRs.
In that case, the convention is to add "[Draft]" to the beginning of the PR name, and leave it there
untile the PR is complete and ready to be actually merged (this doesn't mean the code has passed code-review,
but that the feature you are requesting to pull is already complete).


7) Comments:
------------

Comments in the code must **always** be meaningful and provide a clear explanation of whatever
they are commenting. Good code should be self-documenting, so in cases when you feel a comment is
needed, think if you should not actually split your code into more clearly-named functions.
That being said, comments are still necessary, and good practice. The main type of encouraged documentation
is the functions/classes documentation. That must be done using PHPDoc blocks for classes methods and functions.
This documentation should be **required** on any public method, or not clear protected/private method,
and will be happily received on any other method.


8) Deployment:
--------------

Versions to deploy **MUST** be tagged before deploying, to allow a quick and easy roll-back in case something
goes wrong. The code must first be uploaded to the staging server and after passing QA inspection, it will
be deployed in production. Deployments should be performed only by users authorized to do so (even if a user
has access to production, that doesn't necessarily mean that he should be allowed to deploy).