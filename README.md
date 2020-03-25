# Groupe de obadia_r

# BACK

# FRONT

Install nvm 
- curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash
- export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

Install and use LongTermSupport Node Version
- nvm install --lts
- nvm use --lts

Install Vue CLI
npm install -g @vue/cli

vue create front