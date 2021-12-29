# Pull base image.
FROM ubuntu:20.04
#Avoid on build interaction "noninteractive"
ARG DEBIAN_FRONTEND=noninteractive

# Install initials
RUN \
  apt-get update && \
  apt-get install -y sudo curl wget net-tools openssh-server inetutils-ping  

#install docker-compose
RUN \
  curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose && \
  chmod +x /usr/local/bin/docker-compose
# Set environment variables.
ENV HOME /root

# COPY required files.
COPY /src /src


# Define working directory.
WORKDIR /src

#CMD ["bash"]
# Define default command.
CMD ["sh" , "-c", "service ssh start && bash"]
#ENTRYPOINT : ["bash","-c","ls"]
