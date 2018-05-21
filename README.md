# Declutter

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jonathanm10/declutter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jonathanm10/declutter/?branch=master)

## Install

### Prerequistes

* Declutter is using [Drifter](https://github.com/liip/drifter), ensure you have its [dependencies](https://github.com/liip/drifter#requirements) installed (Vagrant, VirtualBox or LXC and Ansible).
* You should also install the Vagrant Hostmanager plugin: `$ vagrant plugin install vagrant-hostmanager`

### Download and run the project

```bash
# Clone the repository including the git submodule (that's what --recursive does for you)
$ git clone --recursive git@github.com:Jonathanm10/declutter.git && cd declutter

# Start the vagrant box from within the directory that contains the Vagrantfile.
$ vagrant up
```

You can now access the website at [declutter.lo](http://declutter.lo).
