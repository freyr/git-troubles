# Useful commands
## If you cannot find some answer, please add an [issue](https://github.com/freyr/git-troubles/issues) in github, and describe your problem, I will update this documentation.


```git status``` always shows helpful tips that to do next or in what state repository is. 
It is good practice, to call that command often.

```git merge``` or ```git revert``` can fail due to conflict - in that case you are in the middle of the process and always have option to
continue or abort: just call the command again with parameter --abort or --continue

```git revert``` is safe way to remove errors from previous commits - it will not change the history, 
it will add another commit with exactly opposite changes. This way you can easily revert any commit.
### Reverting a merge-commit (commit with two parents) is not that easy, and you should read that article before:
https://www.git-tower.com/learn/git/faq/undo-git-merge

```git branch``` is a command to manage branches - without parameter it is showing branches that you have already checkout in your local repository. 
With ```-a``` it will show all branches, including remote-one, with ```-m``` it will change name of current branch (put the new name after -m).
With ```-d``` it will remove local branch (you cannot be checkout on it while doing that)

```git rm __filename__``` it is best tool to remove something from repository. 
You can use without any options: this will remove a file from your working directory from repository (after commiting that change).
But if you use it with --cached parameter it will remove the same file only from repository, leaving file itself in your working directory.
It is useful if you want to retain file content (or by adding that file to .gitignore)

```.gitignore``` file contains paters of files to ignore by git. Detailed info of pattern format is located here: https://git-scm.com/docs/gitignore#_pattern_format

## Simple solutions for common problems
* Add change to stage
```git add __filename__``` or ```git add .```

* Remove change from stage (change will remain as unstaged)
```git restore --staged __filename__```

* Remove change from working directory (will reset file content to HEAD)
```git restore __filename__```

* Reset repository state to HEAD (last commited change, this will remove all changes staged or not)
```git reset --hard HEAD```

## Below are commands that should not be done on changes that was already pushed to remote repository as they change history
* Remove last commit but preserve change that was made in that commit 
(useful when commited to wrong branch - after that it's easy to change branch and commit those changes again)
```git reset HEAD^```

* Remove last commit and discard all changes that was made in it (it will be like this commit was never made and all changes all lost)
```git reset --hard HEAD^```


### Useful configuration entries
All configuration is done in ~/.gitconfig file. You could also use ```git config --global``` command - then use 'dot format' - eg:
```git config --global core.pager cat```

If ```git log``` returns more than one page of results then it is using ```less``` to cycle through pages - this could be confusing if you arent familar with that tool (it requires hitting 'q' to quit)
to aboid that you could change pager tool to 'cat' - this will output entire log at once and exits to bash.
```bash
[core]
  pager=cat
```

Helpful aliases
```bash
[alias]
    logline = log --graph --pretty=format:'%Cred%h%Creset -%C(yellow)%d%Creset %s %Cgreen(%cr) %C(bold blue)<%an>%Creset' --abbrev-commit
    distance = "!f() { git --no-pager log --oneline --graph --first-parent --left-right --no-decorate HEAD...$1/${2:-$(git rev-parse --abbrev-ref HEAD)}; }; f"
    compare = "!f() { git log --oneline --graph --first-parent --left-right --decorate $1...$2; }; f"
    append = commit --amend -C HEAD
[core]
	pager = cat
	
[help]
	autocorrect = 1
```
