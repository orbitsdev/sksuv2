

import oss from 'ali-oss';



class OSS {
  multipartUpload(location, file, progress, config) {
    const client = new oss({
      accessKeyId: config.stsId,
      accessKeySecret: config.stsKey,
      region: config.region,
      stsToken: config.stsToken,
      bucket: config.bucket,
    });
    try {
      client.multipartUpload(location, file, {
        parallel: 4,
        progress,
        partclientSize: 1 * 1024 * 1024,
      }).then((result) => {
        return result
      })
    } catch (e) {
      if (e.code === 'ConnectionTimeoutError') {
        console.log('TimeoutError');

      }
      console.log(e);
    }
  }
}

export default new OSS();
