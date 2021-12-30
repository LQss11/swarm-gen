# Pull base image.
FROM docker:dind

# Install initials
RUN \
  apk update && \
  apk add curl wget net-tools iputils 

# Setup SSH Service
RUN \
    apk add openssh-server && \
    apk add openrc --no-cache && \
    rc-update add sshd && \
    rc-status && \
    touch /run/openrc/softlevel 

# install docker-compose
RUN \
  curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose && \
  chmod +x /usr/local/bin/docker-compose
 

# COPY required files.
COPY /src /src

# Define working directory.
WORKDIR /src

# Expose port for ssh
EXPOSE 22

# Start SSH Service
CMD ["sh" , "-c", "service sshd restart && sh"]