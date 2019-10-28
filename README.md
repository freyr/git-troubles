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

### REVERT MERGE
https://github.com/git/git/blob/master/Documentation/howto/revert-a-faulty-merge.txt
