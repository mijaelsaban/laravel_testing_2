!function(n){var r={series:{curvedLines:{active:!1,apply:!1,monotonicFit:!1,tension:.5,nrSplinePoints:20,legacyOverride:void 0}}};jQuery.plot.plugins.push({init:function(n){function r(n,r,i){var t=i.points.length/i.pointsize;if(!function(n){if(void 0!==n.fit||void 0!==n.curvePointFactor||void 0!==n.fitPointDist)throw new Error("CurvedLines detected illegal parameters. The CurvedLines API changed with version 1.0.0 please check the options object.");return!1}(r.curvedLines)&&1==r.curvedLines.apply&&void 0===r.originSeries&&t>1.005)if(r.lines.fill){var o=e(i,r.curvedLines,1),s=e(i,r.curvedLines,2);i.pointsize=3,i.points=[];for(var u=0,v=0,a=0;a<o.length||u<s.length;)o[a]==s[u]?(i.points[v]=o[a],i.points[v+1]=o[a+1],i.points[v+2]=s[u+1],u+=2,a+=2):o[a]<s[u]?(i.points[v]=o[a],i.points[v+1]=o[a+1],i.points[v+2]=v>0?i.points[v-1]:null,a+=2):(i.points[v]=s[u],i.points[v+1]=v>1?i.points[v-2]:null,i.points[v+2]=s[u+1],u+=2),v+=3}else r.lines.lineWidth>0&&(i.points=e(i,r.curvedLines,1),i.pointsize=2)}function e(n,r,e){if(void 0!==r.legacyOverride&&0!=r.legacyOverride){var i={fit:!1,curvePointFactor:20,fitPointDist:void 0};return function(n,r,e){var i=n.points,t=n.pointsize,o=Number(r.curvePointFactor)*(i.length/t),s=new Array,u=new Array,v=-1,a=-1,p=0;if(r.fit){var h;if(void 0===r.fitPointDist){var f=i[0];h=(i[i.length-t]-f)/5e4}else h=Number(r.fitPointDist);for(var l=0;l<i.length;l+=t){var c,d;a=l+e,c=i[v=l]-h,d=i[v]+h;for(var g=2;c==i[v]||d==i[v];)c=i[v]-h*g,d=i[v]+h*g,g++;s[p]=c,u[p]=i[a],s[++p]=i[v],u[p]=i[a],s[++p]=d,u[p]=i[a],p++}}else for(l=0;l<i.length;l+=t)v=l,a=l+e,s[p]=i[v],u[p]=i[a],p++;var y=s.length,w=new Array,L=new Array;w[0]=0,w[y-1]=0,L[0]=0;for(l=1;l<y-1;++l){var P=s[l+1]-s[l-1];if(0==P)return[];var m=(s[l]-s[l-1])/P,A=m*w[l-1]+2;w[l]=(m-1)/A,L[l]=(u[l+1]-u[l])/(s[l+1]-s[l])-(u[l]-u[l-1])/(s[l]-s[l-1]),L[l]=(6*L[l]/(s[l+1]-s[l-1])-m*L[l-1])/A}for(p=y-2;p>=0;--p)w[p]=w[p]*w[p+1]+L[p];var z=(s[y-1]-s[0])/(o-1),b=new Array,D=new Array,F=new Array;for(b[0]=s[0],D[0]=u[0],F.push(b[0]),F.push(D[0]),p=1;p<o;++p){b[p]=b[0]+p*z;for(var O=y-1,N=0;O-N>1;){var j=Math.round((O+N)/2);s[j]>b[p]?O=j:N=j}var k=s[O]-s[N];if(0==k)return[];var S=(s[O]-b[p])/k,C=(b[p]-s[N])/k;D[p]=S*u[N]+C*u[O]+((S*S*S-S)*w[N]+(C*C*C-C)*w[O])*(k*k)/6,F.push(b[p]),F.push(D[p])}return F}(n,jQuery.extend(i,r.legacyOverride),e)}return function(n,r,e){for(var i=n.points,t=n.pointsize,o=function(n,r,e){for(var i=n.points,t=n.pointsize,o=[],s=[],u=0;u<i.length-t;u+=t){var v=u+e,a=i[(y=u)+t]-i[y],p=i[v+t]-i[v];o.push(a),s.push(p/a)}var h=[s[0]];if(r.monotonicFit)for(u=1;u<o.length;u++){var f=s[u],l=s[u-1];if(f*l<=0)h.push(0);else{var c=o[u],d=o[u-1],g=c+d;h.push(3*g/((g+c)/l+(g+d)/f))}}else for(u=t;u<i.length-t;u+=t){var y=u;v=u+e;h.push(Number(r.tension)*(i[v+t]-i[v-t])/(i[y+t]-i[y-t]))}h.push(s[s.length-1]);var w=[],L=[];for(u=0;u<o.length;u++){var P=h[u],m=h[u+1],A=(f=s[u],1/o[u]);g=P+m-f-f;w.push(g*A*A),L.push((f-g-P)*A)}var z=[];for(u=0;u<o.length;u++){var b=function(n,r,e,i,t){return function(o){var s=o-n,u=s*s;return r*s*u+e*u+i*s+t}};z.push(b(i[u*t],w[u],L[u],h[u],i[u*t+e]))}return z}(n,r,e),s=[],u=0,v=0;v<i.length-t;v+=t){var a=v,p=v+e,h=i[a],f=i[a+t],l=(f-h)/Number(r.nrSplinePoints);s.push(i[a]),s.push(i[p]);for(var c=h+=l;c<f;c+=l)s.push(c),s.push(o[u](c));u++}return s.push(i[i.length-t]),s.push(i[i.length-t+e]),s}(n,r,e)}n.hooks.processOptions.push((function(n,e){e.series.curvedLines.active&&n.hooks.processDatapoints.unshift(r)}))},options:r,name:"curvedLines",version:"1.1.1"})}();
