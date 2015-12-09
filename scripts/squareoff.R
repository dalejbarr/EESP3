todo <- list.files("tmpstim", 
                   pattern=".png$", full.names=TRUE)

ff <- lapply(todo, function(x) {
    f1 <- system(paste("identify -format '%w %h'", x), intern=TRUE)
      f2 <- as.numeric(strsplit(f1, " ")[[1]])
      return(list(fname=x, dim=f2))
  })

gg <- unlist(lapply(ff, function(x) {
  dims <- x$dim
  dimdiff <- round((dims[2]-dims[1])/2)
  if (dimdiff < 0) {
    fstr <- paste("0x", abs(dimdiff), sep="")
  } else {
    fstr <- paste(abs(dimdiff), "x0", sep="")
  }
  cmdstr <- paste("mogrify -bordercolor white", "-border", fstr, x$fname)
  return(cmdstr)
}))

lapply(gg, system)
