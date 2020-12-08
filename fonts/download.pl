#!/usr/bin/perl

#######################################################
# Helper script to download all fond definitions
# from Google Fonts.
#
# 1. Go to https://fonts.google.com
# 2. Search and select all your fonts
# 3. Click on "Embed" -> "<link>" at the right
# 4. Copy the URL from the import link and open in webbrowser
# 5. Save the CSS file in this folder under your name, e.g.  "<font name>.css"
# 6. Start "download.pl font-name.css >font-name-local.css"
# 
# You can now use either CSS file in your website.
#######################################################
my $stylesheet = shift;

my $targetDir = $stylesheet;
$targetDir =~ s/\.css$//;

if (open(FIN, "<$stylesheet")) {
	if (!-d $targetDir) {
		system("mkdir $targetDir");
	}

	while (<FIN>) {
		chomp;
		my $line = $_;
		my $url = $line;
		if ($url =~ /src:.*url\((http[^\)]+)\)/) {
			$url = $1;
			($url =~ /\/([^\/]+)$/) && ($filename = $1);
			my $targetFile = "$targetDir/$filename";
			if (!-f $targetFile) {
				system("wget -O $targetFile $url");
			}
			$line =~ s/$url/$targetFile/;
			print "$line\n";
		} else {
			print "$line\n";
		}
	}
	close(FIN);
}

