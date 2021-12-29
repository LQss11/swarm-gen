# Pull base image.
FROM ubuntu:20.04
#Avoid on build interaction "noninteractive"
ARG DEBIAN_FRONTEND=noninteractive

# Install initials
RUN \
  apt-get update && \
  apt-get install -y sudo curl wget net-tools openssh-server inetutils-ping  
  
# Set environment variables.
ENV HOME /root

# COPY required files.
COPY /src /src

# Define working directory.
WORKDIR /src

# Define default command.
CMD ["bash"]

CMD "service ssh start"