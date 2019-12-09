### Simple solutions for common problem

* Remove file from stage (changes will be preserved)

```git reset file_name HEAD```

* Reset file content (all changes to that file will be lost)

```git checkout -- file_name```

* Reset whole repository to state from last commit (all local changes will be lost)

```git reset --hard HEAD```

* Remove last commit but preserve change that was made in that commit 
(useful when commited to wrong branch - after that it's easy to change branch and commit those changes again)

```git reset HEAD^```

* Remove last commit and discard all changes that was made in it (it will be like this commit was never made and all changes all lost)

```git reset --hard HEAD^```

#### Additional info
* It is not possible to use git reset command with both --hard flag and file_name. Hard flag works only on whole repository.
* Above solutions are good only if changes were not pushed do remote repository. After push they still could be done but there could be side effects if pushed changes where pulled by others. 
In this case after making solutions 4th or 5th, pushing will require --force flag to overwrite remote branch/. 
Also, others after pulling again will be forced to merge. This is confusing to some and might cause problems.

To avoid those problems it is much better to use git revert to remove commit changes without removing actual commits.

### Advanced merge tactics

https://github.com/git/git/blob/master/Documentation/howto/revert-a-faulty-merge.txt

### Useful aliases
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
