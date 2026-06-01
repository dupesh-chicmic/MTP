#!/bin/bash
echo "----------------------------------------------------------------"
echo " Running $0 to check for letsencrypt certificate and renewal"
echo "--------------------------------------------------------------- -"
export APACHE_RUN_USER=www-data
export APACHE_RUN_GROUP=www-data
export APACHE_RUN_DIR=/var/run/apache2
cp -pr /etc/letsencrypt/live/dev.mtp.ie-0005/ /var/certs/
ls -al /var/certs/
privateKeyHome="/etc/letsencrypt/live/$(hostname -f)"
privateKeyFile="$privateKeyHome/privkey.pem"
renewalFlags=""
if [ ! -z $LETS_ENCRYPT_FORCE_RENEWAL ]; then
  renewalFlags="$renawalFlags --force-renewal"
fi

echo "Checking if certificate [$privateKeyFile] exist )."
if [ ! -f $privateKeyFile ]; then
  echo "Certificate file [$privateKeyFile] does not exist"

  if [[ ! "x$LETS_ENCRYPT_DOMAINS" == "x" ]]; then
    DOMAIN_CMD="-d $(echo $LETS_ENCRYPT_DOMAINS | sed 's/,/ -d /')"
    cmd="certbot -n certonly --duplicate --no-self-upgrade --agree-tos --standalone --cert-name $(hostname -f) -m \"$LETS_ENCRYPT_EMAIL\" -d $(hostname -f) $DOMAIN_CMD"
    echo "Requesting certificates for [$cmd]"
    eval $cmd
    echo "Linking certificate folder"
  else
    echo "LETS_ENCRYPT_DOMAINS not defined, skipping certificate creation"
  fi
else
  cp -r /etc/letsencrypt/live/$(hostname -f)/ /etc/letsencrypt/certs/
  echo "Certificate file [$privateKeyFile] exist, checking for renewal"
  cmd="certbot renew --apache --no-self-upgrade $renewalFlags"
  echo "Requesting certificate renawal: [$cmd]"
  eval $cmd
fi
ls -al /etc/letsencrypt/live/
ln -s /etc/letsencrypt/live/$(hostname -f) /var/certs
echo "Launching apache2."
apache2 -DFOREGROUND
service apache2 status
