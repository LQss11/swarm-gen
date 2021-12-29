# Pull base image.
FROM ubuntu:20.04
#Avoid on build interaction "noninteractive"
ARG DEBIAN_FRONTEND=noninteractive

# Install initials
RUN \
  sed -i 's/# \(.*multiverse$\)/\1/g' /etc/apt/sources.list && \
  apt-get update && \
  apt-get -y upgrade && \
  apt-get install -y build-essential && \
  apt-get install -y software-properties-common && \
  apt-get install -y byobu curl git htop man unzip vim wget&& \
  rm -rf /var/lib/apt/lists/*
  
# Set environment variables.
ENV HOME /root

# COPY required files.
COPY /src /src

# Define working directory.
WORKDIR /src

# Define default command.
CMD ["bash"]