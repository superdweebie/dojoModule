#Script to be used from the composer bin dir.
#Will build dojo if the default configuration is used.
#If you change the profile or release directory, you will need to
#write your own script

cd ../../../..

echo "Removing old build"
rm -rf public/js/dojo_rel

cd data

echo "Creating new build"
../vendor/dojo/util/buildscripts/build.sh --profile dojo-module.profile.js